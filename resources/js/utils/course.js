export const Status = {
  NOT_STARTED: 'NOT_STARTED',
  COMPLETED: 'COMPLETED',
  CANCELLED: 'CANCELLED'
};

export const getStatusName = (status = 'NOT_STARTED') => {
  switch (status) {
    default:
    case Status.NOT_STARTED: return 'Não iniciado';
    case Status.COMPLETED: return 'Finalizado';
    case Status.CANCELLED: return 'Cancelado';
  }
}

export const getStatusColor = (status = 'NOT_STARTED') => {
  switch (status) {
    default:
    case Status.NOT_STARTED: return 'yellow';
    case Status.COMPLETED: return 'green';
    case Status.CANCELLED: return 'red';
  }
}

export const getStatusContent = (status) => {
  return `<div class="bg-${getStatusColor(status)}-400 px-2 py-1 rounded-full text-white shadow text-center font-xs">${getStatusName(status)}</div>`
}

export const getNextStatus = (currentStatus) => {
  const StatusArray = Object.keys(Status).map((key) => key = Status[key]);

  const currentIndex = StatusArray.indexOf(currentStatus);
  if (currentIndex === -1) {
    return Status[0];
  }
  const nextIndex = (currentIndex + 1) % StatusArray.length;
  return StatusArray[nextIndex];
};