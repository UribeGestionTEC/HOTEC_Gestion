import tkinter as tk
from tkinter import messagebox

def registrar():
    datos = {
        "Nombre": entry_nombre.get(),
        "Apellidos": entry_apellidos.get(),
        "Nacionalidad": entry_nacionalidad.get(),
        "Edad": entry_edad.get(),
        "Correo": entry_correo.get(),
        "Teléfono": entry_telefono.get(),
        "Entrada": entry_entrada.get(),
        "Salida": entry_salida.get(),
        "Habitación": entry_habitacion.get()
    }
    
    if all(datos.values()):
        resumen = "\n".join([f"{k}: {v}" for k, v in datos.items()])
        messagebox.showinfo("Registro exitoso", f"Datos del turista:\n{resumen}")
    else:
        messagebox.showwarning("Campos incompletos", "Por favor llena todos los campos.")

# GUI
root = tk.Tk()
root.title("Registro de Turistas")
root.geometry("500x600")
root.configure(bg="#000000")

frame = tk.Frame(root, bg="#3c3c3c", padx=20, pady=20)
frame.place(relx=0.5, rely=0.5, anchor="center")

titulo = tk.Label(frame, text="Registro de Turistas", font=("Arial", 20, "bold"), fg="#ffcc00", bg="#3c3c3c")
titulo.pack(pady=10)

def crear_entry(label_text):
    tk.Label(frame, text=label_text, fg="white", bg="#3c3c3c").pack()
    entry = tk.Entry(frame, font=("Arial", 10))
    entry.pack(pady=5, fill="x")
    return entry

entry_nombre = crear_entry("Nombre")
entry_apellidos = crear_entry("Apellidos")
entry_nacionalidad = crear_entry("Nacionalidad")
entry_edad = crear_entry("Edad")
entry_correo = crear_entry("Correo Electrónico")
entry_telefono = crear_entry("Teléfono")
entry_entrada = crear_entry("Fecha de Entrada")
entry_salida = crear_entry("Fecha de Salida")
entry_habitacion = crear_entry("Habitación Asignada")

tk.Button(frame, text="Registrar", bg="#4a4a4a", fg="white", font=("Times", 11), command=registrar).pack(pady=15, fill="x")

root.mainloop()
