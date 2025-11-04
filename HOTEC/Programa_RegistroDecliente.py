# generamos un contador para llevar el control de usuarios
contador = 0
# usamos un diccionario como base de datos
usuarios = {}
print('\033c', end='')
# se crea un menú de apertura
print("Bienvenido al sistema de registros de Huesped\n")
print("Por favor, seleccione una opción del menú:")
print("1. Agregar/eliminar Reserva")
print("2. Ver Reservas")
print("3. Salir")
opcion = input("Ingrese el número de la opción deseada: ")
# este print permite limpiar la pantalla sin importar el O.S 
print('\033c', end='')

# el loop while permitirá que el usuario siga trabajando hasta que desee salir
while True:
    # Agrega o eliminar usuarios
    if opcion == "1":
        print("Agregar Reserva")
        print("")
        print("1. Agregar Usuario")
        print("2. Eliminar Usuario")
        opcion = input("Ingrese el número de la opción deseada: ")
        print('\033c', end='')

        # Agregar usuarios
        if opcion == "1":
            print("Agregar Usuario\n")
            nombre = input("Ingrese el nombre del usuario: ")
            apellido = input("Ingrese el apellido del usuario: ")
            print('\033c', end='')
            print ("Usuario:\n")
            # se concatenan las primera letra del nombre y la primera letra del apellido del usuario
            letras = nombre[0]+apellido[0]
            contador += 1
            # las letras pasan a ser Mayusculas y se concatena junto con el str 00 a damás del str contador
            # se genera el codigo de usuario
            codigo = letras.upper() + "00" + str(contador)
            print(f"El codigo del usuario es '{codigo}'")
            usuarios[codigo] = nombre + " " + apellido
            # se confirma el registro del usuario
            print(f"{nombre} {apellido} HA SIDO REGISTRADO EXITOSAMENTE.\n")
            # Imprimir un mensaje pidiendo al usuario que presione Enter para continuar
            input('Presione Enter para continuar...')
            print('\033c', end='')

        # Eliminar usuarios
        elif opcion == "2":
            print("Eliminar Usuario\n")
            codigo = input("Ingrese el codigo del usuario: ")
            # validar que el usuario existe den la base de datos
            # si el usuario existe se procede a eliminarlo
            if codigo in usuarios:
                del usuarios[codigo]
                print(f"EL USUARIO FUE ELIMINADO CON EXITO.")
                input('Presione Enter para continuar...')
                print('\033c', end='')
            else:
                print(f"EL USUARIO NO FUE ENCONTRADO.")
                input('Presione Enter para continuar...')
                print('\033c', end='')
    # Ver los usuarios que están en la base de datos
    elif opcion == "2":
        print("Registros\n")
        print("-"*10)
        # loop para recorrer la base de datos y mostrar los usuarios registrados
        for key, value in usuarios.items():
            print(key, value)
        print("-"*10)
        input('Presione Enter para continuar...')
        print('\033c', end='')
    # salir del programa
    elif opcion == "3":
        break
    else:
        print("Opción inválida. Por favor, seleccione una opción válida del menú.")
    # el menú de apertura se agrega para que pueda seguir funcionando dentro del loop
    print("1. Agregar/eliminar registro")
    print("2. Ver registros")
    print("3. Salir")

    opcion = input("Ingrese el número de la opción deseada: ")
    print('\033c', end='')