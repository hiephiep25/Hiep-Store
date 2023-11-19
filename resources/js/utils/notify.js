import { useQuasar } from 'quasar';

export default function () {
  const $q = useQuasar();

  const showNotify = (message, options = {}) => {
    $q.notify({
      message: message,
      type: 'notify',
      position: 'top-right',
      progress: true,
      timeout: 5000,
      ...options,
    });
  };

  return {
    success: (message, options = {}) => {
      showNotify(message, {
        ...options,
        color: 'green',
        icon: 'task_alt',
      });
    },
    info: (message, options = {}) => {
      showNotify(message, {
        ...options,
        color: 'info',
        icon: 'exclamation',
      });
    },
    warn: (message, options = {}) => {
      showNotify(message, {
        ...options,
        color: 'warning',
        icon: 'warning',
      });
    },
    error: (message, options = {}) => {
      showNotify(message, {
        ...options,
        color: 'negative',
        icon: 'error',
      });
    },
  };
}
