import tkinter as tk
from tkinter import ttk

class Habitacion:
    def __init__(self, numero, tipo, disponible=True):
        self.numero = numero
        self.tipo = tipo
        self.disponible = disponible

# Crear habitaciones
habitaciones = []
for i in range(1, 100):
    if i <= 50:
        tipo = "Sencilla"
    elif i <= 75:
        tipo = "Doble"
    else:
        tipo = "Suite"
    habitaciones.append(Habitacion(i, tipo))

# Interfaz
root = tk.Tk()
root.title("Gestión de Habitaciones  HOTEC")
root.geometry("600x450")
root.configure(bg="#1e1e1e")

frame = tk.Frame(root, bg="#2b2b2b", padx=20, pady=20)
frame.place(relx=0.5, rely=0.5, anchor="center")

tk.Label(frame, text="Habitaciones HOTEC", font=("Times", 18, "bold"),
         fg="#ffcc00", bg="#2b2b2b").pack(pady=10)

# Tabla
columns = ("Número", "Tipo", "Estado")
tabla = ttk.Treeview(frame, columns=columns, show="headings", height=12)

for col in columns:
    tabla.heading(col, text=col)
    tabla.column(col, anchor="center")

tabla.pack(pady=10)

# Estilo
style = ttk.Style()
style.theme_use("default")
style.configure("Treeview", background="#202020", fieldbackground="#202020",
                foreground="white", font=('Times', 10))
style.configure("Treeview.Heading", background="#ffcc00", foreground="black",
                font=('Calibri', 10, 'bold'))

# Funciones
def actualizar_tabla(filtro="Todas"):
    tabla.delete(*tabla.get_children())
    for h in habitaciones:
        if filtro == "Todas" or h.tipo == filtro:
            estado = "Disponible" if h.disponible else "Ocupada"
            tabla.insert("", "end", values=(h.numero, h.tipo, estado))

def cambiar_estado(disponible):
    seleccion = tabla.selection()
    if seleccion:
        numero = int(tabla.item(seleccion[0])["values"][0])
        for h in habitaciones:
            if h.numero == numero:
                h.disponible = disponible
                break
        actualizar_tabla(combo_filtro.get())

# Filtro y botones
filtros = ["Todas", "Sencilla", "Doble", "Suite"]
combo_filtro = ttk.Combobox(frame, values=filtros, state="readonly")
combo_filtro.set("Todas")
combo_filtro.pack(pady=5)
combo_filtro.bind("<<ComboboxSelected>>", lambda e: actualizar_tabla(combo_filtro.get()))

botones = tk.Frame(frame, bg="#2b2b2b")
botones.pack(pady=10)

tk.Button(botones, text="Marcar como Ocupada", command=lambda: cambiar_estado(False),
          bg="#444", fg="white", width=20).pack(side="left", padx=5)

tk.Button(botones, text="Marcar como Disponible", command=lambda: cambiar_estado(True),
          bg="#444", fg="white", width=20).pack(side="left", padx=5)

actualizar_tabla()
root.mainloop()
