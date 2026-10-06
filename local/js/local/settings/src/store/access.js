import { defineStore } from 'pinia';

export const useAccessStore = defineStore({
  id: 'access',
  state: () => ({
    isAccess: false,
  }),
  actions: {
    getAccess() {
      fetch('/local/js/local/settings/api/access.php')
        .then((response) => {
          if (!response.ok) {
            throw new Error(`Request failed with status ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          this.isAccess = data;
        });
    },
  },
});
