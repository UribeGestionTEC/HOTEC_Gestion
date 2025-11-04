import tkinter as tk
from tkinter import messagebox, ttk

class Habitacion:
    def __init__(self, numero, tipo, disponible=True):
        self.numero = numero
        self.tipo = tipo
        self.disponible = disponible

# Crear habitaciones
habitaciones = []
for i in range(1, 21):
    if i <= 5:
        tipo = "Sencilla"
    elif i <= 14:
        tipo = "Doble"
    else:
        tipo = "Suite"
    habitaciones.append(Habitacion(i, tipo))

# Gestion de habitaciones 
def abrir_gestion_habitaciones():
    gestion = tk.Toplevel()
    gestion.title("Gestión de Habitaciones HOTEC")
    gestion.geometry("600x450")
    gestion.configure(bg="#1e1e1e")

    frame = tk.Frame(gestion, bg="#2b2b2b", padx=20, pady=20)
    frame.place(relx=0.5, rely=0.5, anchor="center")

    tk.Label(frame, text="Habitaciones HOTEC", font=("Times", 18, "bold"), fg="#ffcc00", bg="#2b2b2b").pack(pady=10)

    columns = ("Número", "Tipo", "Estado")
    tabla = ttk.Treeview(frame, columns=columns, show="headings", height=12)

    for col in columns:
        tabla.heading(col, text=col)
        tabla.column(col, anchor="center")

    tabla.pack(pady=10)

    style = ttk.Style()
    style.theme_use("default")
    style.configure("Treeview", background="#202020", fieldbackground="#202020", foreground="white", font=('Times', 10))
    style.configure("Treeview.Heading", background="#ffcc00", foreground="black", font=('Calibri', 10, 'bold'))

    def actualizar_tabla(filtro="Todas"):
        tabla.delete(*tabla.get_children())
        for h in habitaciones:
            if filtro == "Todas" or h.tipo == filtro:
                estado = "Disponible" if h.disponible else "Ocupada"
                tabla.insert("", "end", values=(h.numero, h.tipo, estado))

    def cambiar_estado(disponible):
        seleccion = tabla.selection()
        if seleccion:
            numero = int(tabla.item(seleccion[0])['values'][0])
            for h in habitaciones:
                if h.numero == numero:
                    h.disponible = disponible
                    break
            actualizar_tabla(combo_filtro.get())

    filtros = ["Todas", "Sencilla", "Doble", "Suite"]
    combo_filtro = ttk.Combobox(frame, values=filtros, state="readonly")
    combo_filtro.set("Todas")
    combo_filtro.pack(pady=5)
    combo_filtro.bind("<<ComboboxSelected>>", lambda e: actualizar_tabla(combo_filtro.get()))

    botones = tk.Frame(frame, bg="#2b2b2b")
    botones.pack(pady=10)

    tk.Button(botones, text="Marcar como Ocupada", command=lambda: cambiar_estado(False), bg="#444", fg="white", width=20).pack(side="left", padx=5)
    tk.Button(botones, text="Marcar como Disponible", command=lambda: cambiar_estado(True), bg="#444", fg="white", width=20).pack(side="left", padx=5)

    actualizar_tabla()

#  Registro de huespedes
def abrir_registro():
    registro = tk.Toplevel()
    registro.title("Registro de Turistas")
    registro.geometry("500x600")
    registro.configure(bg="#000000")

    frame = tk.Frame(registro, bg="#3c3c3c", padx=20, pady=20)
    frame.place(relx=0.5, rely=0.5, anchor="center")

    tk.Label(frame, text="Registro de Turistas", font=("Arial", 20, "bold"), fg="#ffcc00", bg="#3c3c3c").pack(pady=10)

    def crear_entry(label_text):
        tk.Label(frame, text=label_text, fg="white", bg="#3c3c3c").pack()
        entry = tk.Entry(frame, font=("Arial", 10))
        entry.pack(pady=5, fill="x")
        return entry

    entry_nombre = crear_entry("Nombre")
    entry_apellidos = crear_entry("Apellidos")
    entry_nacionalidad = crear_entry("Nacionalidad")
    entry_edad = crear_entry("Edad")
    entry_entrada = crear_entry("Fecha de Entrada")
    entry_salida = crear_entry("Fecha de Salida")

    def registrar():
        if all(entry.get() for entry in [entry_nombre, entry_apellidos, entry_nacionalidad, entry_edad, entry_entrada, entry_salida]):
            messagebox.showinfo("Registro exitoso", "Registro completado")
            abrir_gestion_habitaciones()
            registro.destroy()
        else:
            messagebox.showwarning("No ha escrito algo!!", "Por favor, llena todos los campos.")

    tk.Button(frame, text="Registrar", bg="#4a4a4a", fg="white", font=("Times", 11), command=registrar).pack(pady=15, fill="x")


# Ventana principal (Login)
root = tk.Tk()
root.title("Bienvenido al sistema 'HOTEC' Escriba su informacion!")
root.geometry("500x600")
root.configure(bg="#000000")

frame = tk.Frame(root, bg="#3c3c3c", padx=40, pady=40)
frame.place(relx=0.5, rely=0.5, anchor="center")

tk.Label(frame, text="Login HOTEC", font=("Arial", 24, "bold"), fg="#ffcc00", bg="#3c3c3c").pack(pady=(0, 10))

entry_nombre = tk.Entry(frame, font=("Arial", 12))
entry_nombre.insert(0, "Nombre")
entry_nombre.pack(pady=5, fill="x")

entry_clave = tk.Entry(frame, font=("Arial", 12))
entry_clave.insert(0, "Clave de acceso")
entry_clave.pack(pady=5, fill="x")

entry_contrasena = tk.Entry(frame, font=("Arial", 12), show="*")
entry_contrasena.insert(0, "***********")
entry_contrasena.pack(pady=5, fill="x")

def login():
    if all(entry.get() for entry in [entry_nombre, entry_clave, entry_contrasena]):
        abrir_registro()
        root.withdraw()
    else:
        messagebox.showwarning("No hay datos", "Por favor llena todos los campos")

tk.Button(frame, text="Entrar", font=("Arial", 12), bg="#4a4a4a", fg="white", command=login).pack(pady=(20, 10), fill="x")

root.mainloop()