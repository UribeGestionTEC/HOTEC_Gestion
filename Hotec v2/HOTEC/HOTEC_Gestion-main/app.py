from flask import Flask, render_template, request, redirect, url_for, session, flash
import psycopg2
import psycopg2.extras

app = Flask(__name__)
app.secret_key = "hotec_secret_2025"

DB_CONFIG = {
    "host": "localhost",
    "port": 5432,
    "dbname": "hotec",
    "user": "postgres",
    "password": "jose0305"
}

def get_db():
    return psycopg2.connect(**DB_CONFIG)


# ─── INICIO ────────────────────────────────────────────────────────────────────

@app.route("/")
def index():
    return render_template("index.html")


# ─── REGISTRO DE USUARIO ───────────────────────────────────────────────────────

@app.route("/registro", methods=["GET", "POST"])
def registro():
    if request.method == "POST":
        nombre    = request.form["nombre"]
        apellido  = request.form["apellido"]
        correo    = request.form["correo"]
        contrasena = request.form["password"]
        try:
            conn = get_db()
            cur = conn.cursor()
            cur.execute(
                "INSERT INTO usuarios (nombre, apellido, correo_e, contrasena) VALUES (%s, %s, %s, %s)",
                (nombre, apellido, correo, contrasena)
            )
            conn.commit()
            cur.close()
            conn.close()
            flash("Registro exitoso. Ahora puedes iniciar sesión.", "success")
            return redirect(url_for("login"))
        except psycopg2.errors.UniqueViolation:
            flash("Error: Este correo ya está registrado.", "error")
            return redirect(url_for("registro"))
    return render_template("registro.html")


# ─── LOGIN ─────────────────────────────────────────────────────────────────────

@app.route("/login", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        correo    = request.form["correo_e"]
        contrasena = request.form["contrasena"]
        conn = get_db()
        cur = conn.cursor(cursor_factory=psycopg2.extras.DictCursor)
        cur.execute("SELECT id_user, contrasena FROM usuarios WHERE correo_e = %s", (correo,))
        usuario = cur.fetchone()
        cur.close()
        conn.close()
        if usuario and contrasena == usuario["contrasena"]:
            session["id_user"] = usuario["id_user"]
            flash("Bienvenido otra vez!", "success")
            return redirect(url_for("reservas"))
        else:
            flash("Correo o contraseña incorrectos.", "error")
    return render_template("login.html")


@app.route("/logout")
def logout():
    session.clear()
    return redirect(url_for("index"))


# ─── RESERVAS ──────────────────────────────────────────────────────────────────

@app.route("/reservas", methods=["GET", "POST"])
def reservas():
    if "id_user" not in session:
        flash("Debes iniciar sesión primero.", "error")
        return redirect(url_for("login"))
    if request.method == "POST":
        nombre       = request.form["nombre"]
        apellido     = request.form["apellido"]
        check_in     = request.form["check_in"]
        check_out    = request.form["check_out"]
        nacionalidad = request.form["nacionalidad"]
        conn = get_db()
        cur = conn.cursor()
        cur.execute(
            "INSERT INTO reserva (nombre, apellido, nacionalidad, check_in, check_out) VALUES (%s, %s, %s, %s, %s)",
            (nombre, apellido, nacionalidad, check_in, check_out)
        )
        conn.commit()
        cur.close()
        conn.close()
        flash("Reserva registrada con éxito.", "success")
        return redirect(url_for("reservas"))
    return render_template("reservas.html")


# ─── CHECK-OUT ─────────────────────────────────────────────────────────────────

@app.route("/checkout", methods=["GET", "POST"])
def checkout():
    if request.method == "POST":
        nombre     = request.form["nombre"].strip().lower()
        apellido   = request.form["apellido"].strip().lower()
        id_reserva = int(request.form["ID_Reserva"])
        fecha      = request.form["fecha"]
        conn = get_db()
        cur = conn.cursor()
        cur.execute(
            "SELECT id FROM reserva WHERE id = %s AND LOWER(nombre) = %s AND LOWER(apellido) = %s AND check_out = %s",
            (id_reserva, nombre, apellido, fecha)
        )
        reserva = cur.fetchone()
        if reserva:
            cur.execute("DELETE FROM reserva WHERE id = %s", (id_reserva,))
            conn.commit()
            flash("Check-Out realizado con éxito.", "success")
        else:
            flash("No se encontró una reserva con los datos proporcionados.", "error")
        cur.close()
        conn.close()
    return render_template("checkout.html")


# ─── HABITACIONES ──────────────────────────────────────────────────────────────

@app.route("/habitaciones", methods=["GET", "POST"])
def habitaciones():
    conn = get_db()
    cur = conn.cursor(cursor_factory=psycopg2.extras.DictCursor)

    if request.method == "POST":
        accion = request.form.get("accion")
        numero = request.form.get("numero")

        if accion == "registrar":
            tipo  = request.form["tipo"]
            num_h = int(request.form["num_h"])
            cur.execute("SELECT id_habitacion FROM habitacion WHERE numero = %s", (numero,))
            existe = cur.fetchone()
            if existe:
                cur.execute(
                    "UPDATE habitacion SET tipo=%s, estado='Ocupada', num_huespedes=%s WHERE numero=%s",
                    (tipo, num_h, numero)
                )
            else:
                cur.execute(
                    "INSERT INTO habitacion (numero, tipo, estado, num_huespedes) VALUES (%s, %s, 'Disponible', %s)",
                    (numero, tipo, num_h)
                )
            conn.commit()
            flash("Habitación registrada correctamente.", "success")

        elif accion == "liberar":
            cur.execute(
                "UPDATE habitacion SET estado='Disponible', num_huespedes=0 WHERE numero=%s",
                (numero,)
            )
            conn.commit()
            flash("Habitación liberada.", "success")

        elif accion == "ocupar":
            cur.execute(
                "UPDATE habitacion SET estado='Ocupada' WHERE numero=%s",
                (numero,)
            )
            conn.commit()
            flash("Habitación marcada como ocupada.", "success")

    cur.execute("SELECT * FROM habitacion ORDER BY numero ASC")
    lista = cur.fetchall()
    cur.close()
    conn.close()
    return render_template("habitaciones.html", habitaciones=lista)


# ─── TIPOS DE HABITACIONES (informativo) ───────────────────────────────────────

@app.route("/tipos")
def tipos():
    return render_template("tipos.html")


if __name__ == "__main__":
    app.run(debug=True)
