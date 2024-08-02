export const getStatusName = (status = 'NOT_STARTED') => {
  switch (status) {
    default:
    case 'NOT_STARTED': return 'Não iniciado';
    case 'COMPLETED': return 'Finalizado';
    case 'CANCELLED': return 'Cancelado';
  }
}

export const getStatusColor = (status = 'NOT_STARTED') => {
  switch (status) {
    default:
    case 'NOT_STARTED': return 'yellow';
    case 'COMPLETED': return 'green';
    case 'CANCELLED': return 'red';
  }
}