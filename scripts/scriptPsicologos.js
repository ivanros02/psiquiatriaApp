
function mostrarInformacion(button) {
  const psychologistId = button.dataset.id;
  window.location.href = `../presentacion/presentacionProfesional.php?id=${psychologistId}`;
}





