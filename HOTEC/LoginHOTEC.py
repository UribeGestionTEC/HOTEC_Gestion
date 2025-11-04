import tkinter as tk
from tkinter import messagebox

# EQUIPO 5 HOTEC, Bienvenido, este es el codigo de login, aqui veras algunos campos que te ayudaran a realizar tu trabajo.
# Funcion int"
def login():
    nombre = entry_nombre.get()
    clave = entry_clave.get()
    contrasena = entry_contrasena.get()
    if nombre and clave and contrasena:
        messagebox.showinfo("Acceso", f"Bienvenido {nombre}")
    else:
        messagebox.showwarning("Campos vacíos", "Por favor llena todos los campos")

# Ventana principal
root = tk.Tk()
root.title("Registro HOTEC")
root.geometry("500x600")
root.configure(bg="#000000")

# Contenedor principal
frame = tk.Frame(root, bg="#3c3c3c", padx=40, pady=40)
frame.place(relx=0.5, rely=0.5, anchor="center")

# Título del documento - Registros HOTEC
titulo = tk.Label(frame, text="Registro HOTEC", font=("Arial", 24, "bold"), fg="#ffcc00", bg="#3c3c3c")
titulo.pack(pady=(0, 10))

# Subtítulos (Bienvenida)
subtitulo = tk.Label(
    frame,
    text="Bienvenido al sistema HOTEC, por \n favor ingresa tu nombre y matrícula\npara acceder",
    font=("Arial", 10),
    fg="white",
    bg="#3c3c3c",
    justify="center"
)
subtitulo.pack(pady=(0, 20))


# Campos de entrada

entry_nombre = tk.Entry(frame, font=("Arial", 12))
entry_nombre.insert(0, "Nombre")
entry_nombre.pack(pady=5, fill="x")


entry_clave = tk.Entry(frame, font=("Arial", 12))
entry_clave.insert(0, "Clave")
entry_clave.pack(pady=5, fill="x")


entry_contrasena = tk.Entry(frame, font=("Arial", 12), show="*")
entry_contrasena.insert(0, "Contraseña")
entry_contrasena.pack(pady=5, fill="x")

# Botón de entrar
btn_entrar = tk.Button(frame, text="Entrar", font=("Arial", 12), bg="#4a4a4a", fg="white", command=login)
btn_entrar.pack(pady=(20, 10), fill="x")

# Términos y condiciones
terminos = tk.Label(frame, text="Material del equipo 5, HOTEC", font=("Arial", 8), fg="white", bg="#3c3c3c")
terminos.pack(pady=(10, 0))

root.mainloop()