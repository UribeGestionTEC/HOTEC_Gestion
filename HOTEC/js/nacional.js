const paises = [
  { code: "AF", name: "Afganistán" },
  { code: "AL", name: "Albania" },
  { code: "DE", name: "Alemania" },
  { code: "AD", name: "Andorra" },
  { code: "AO", name: "Angola" },
  { code: "AR", name: "Argentina" },
  { code: "MX", name: "México" },
  { code: "ES", name: "España", selected: true },
  // Agrega más países aquí
];

const selectElement = document.getElementById("paisSelect");
paises.forEach(pais => {
  const option = document.createElement("option");
  option.value = pais.code;
  option.textContent = pais.name;
  if (pais.selected) option.selected = true;
  selectElement.appendChild(option);
});
