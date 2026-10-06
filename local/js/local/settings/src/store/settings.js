import { toRaw } from 'vue';
import { defineStore } from 'pinia';
import { getSessid } from '@/utils/sessid.js';
/* eslint-disable */
export const useSettingsStore = defineStore({
  id: 'settings',
  state: () => ({
    language: true,
    languageConfig: [],
    section: 'actual',
    isLoading: false,
    file: false,
    isDisabled: true,
    isErr: false,
    err: '',
    percentage: 0,
    count: 0,
    mode: 'settings',
    config: false,
    progress: '',
  }),
  actions: {
    setFile(file) {
      // console.log(file);
      this.file = file;
      if (file && file.is_upload) {
        this.isDisabled = false;
      } else {
        this.isDisabled = true;
      }
    },
    uploadMore() {
      this.percentage = 0;
      this.count = 0;
      this.language = true;
      this.section = 'actual';
      this.progress = '';

      this.file = false;
      this.isDisabled = true;
      this.isErr = false;
      this.err = '';
      this.isLoading = false;
      this.mode = 'settings';
    },
    uploadSettings() {
      this.percentage = 0;
      this.count = 0;
      this.isLoading = true;
      this.progress = '';

      const file = toRaw(this.file);
      const lang = this.language;

      if (file) {
        const url = '/local/js/local/settings/api/upload-settings.php';
        const data = new FormData();



        data.append('LANGUAGE', lang);
        data.append('SECTION', this.section);
        data.append('FILE', JSON.stringify(file));
        data.append('sessid', getSessid());

        fetch(url, {
          method: 'post',
          body: data,
          credentials: 'include',
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(`Request failed with status ${response.status}`);
            }
            return response.json();
          })
          .then((data) => {
            if (data && data.data) {
              this.isErr = false;
              this.err = '';
              this.count = data.data.length;
              let sections = [];
              this.progress = 'Удаляем элементы';

              const elements = data.elements;
              if (elements && elements.length) {
                const elementsCount = elements.length;

                let size = 100;
                let subElements = []; //массив в который будет выведен результат.
                for (let i = 0; i < Math.ceil(elements.length / size); i++) {
                  subElements[i] = elements.slice(i * size, i * size + size);
                }
                if (subElements.length) {
                  let i = 0;

                  return new Promise((res, rej) => {
                    const deleteElements = (elements, i) => {
                      const rowData = new FormData();
                      rowData.append('ELEMENTS', JSON.stringify(elements));
                      rowData.append('sessid', getSessid());
                      this.progress =
                        'Удаляем элементы ' +
                        ((i - 1) * size + elements.length) +
                        '/' +
                        elementsCount;

                      fetch('/local/js/local/settings/api/delete-elems.php', {
                        method: 'post',
                        body: rowData,
                        credentials: 'include',
                      })
                        .then((response) => {
                          if (!response.ok) {
                            throw new Error(
                              `Request failed with status ${response.status}`
                            );
                            this.isErr = true;
                            this.err = 'Что-то пошло не так';
                            return rej(false);
                          }
                          return response.json();
                        })
                        .then((row) => {
                          if (i < subElements.length) {
                            i++;
                            if (subElements[i] && subElements[i].length) {
                              deleteElements(subElements[i], i);
                            } else {
                              return res(data);
                            }
                          } else {
                            this.isErr = false;
                            this.err = '';
                            return data;
                          }
                        });
                    };

                    deleteElements(subElements[0], 0);
                  });
                }
              }
            }
            return data;
          })
          .then((data) => {
            if (data && data.data) {
              this.progress = 'Удаляем разделы';

              const sections = data.sections;
              if (sections && sections.length) {
                const sectionsCount = sections.length;

                let size = 50;
                let subSections = [];
                for (let i = 0; i < Math.ceil(sections.length / size); i++) {
                  subSections[i] = sections.slice(i * size, i * size + size);
                }
                if (subSections.length) {
                  let i = 0;

                  return new Promise((resolve, reject) => {
                    const deleteSections = (sections, i) => {
                      const rowData = new FormData();
                      rowData.append('SECTIONS', JSON.stringify(sections));
                      rowData.append('sessid', getSessid());
                      this.progress =
                        'Удаляем разделы ' +
                        ((i - 1) * size + sections.length) +
                        '/' +
                        sectionsCount;

                      fetch(
                        '/local/js/local/settings/api/delete-sections.php',
                        {
                          method: 'post',
                          body: rowData,
                          credentials: 'include',
                        }
                      )
                        .then((response) => {
                          if (!response.ok) {
                            throw new Error(
                              `Request failed with status ${response.status}`
                            );
                            this.isErr = true;
                            this.err = 'Что-то пошло не так';
                            return reject(false);
                          }
                          return response.json();
                        })
                        .then((row) => {
                          if (i < subSections.length) {
                            i++;
                            if (subSections[i] && subSections[i].length) {
                              deleteSections(subSections[i], i);
                            } else {
                              return resolve(data);
                            }
                          } else {
                            this.isErr = false;
                            this.err = '';
                            return resolve(data);
                          }
                        });
                    };
                    deleteSections(subSections[0], 0);
                  });
                }
              }
            }
            return data;
          })
          .then((data) => {
            let sections = [];
            console.log(data);
            if (data && data.data) {
              this.progress = 'Добавляем элементы';
              let i = 0;
              const stepRow = (row, i) => {
                const rowData = new FormData();
                rowData.append('sessid', getSessid());
                rowData.append('ROW', JSON.stringify(row));
                rowData.append('FILTER', JSON.stringify(data.filter));
                rowData.append('SECTIONS', JSON.stringify(sections));
                rowData.append('LANGUAGE', lang);

                if (this.count) {
                  this.percentage = parseInt((i / this.count) * 100, 10);
                }

                fetch('/local/js/local/settings/api/upload-row.php', {
                  method: 'post',
                  body: rowData,
                  credentials: 'include',
                })
                  .then((response) => {
                    if (!response.ok) {
                      throw new Error(
                        `Request failed with status ${response.status}`
                      );
                      this.isErr = true;
                      this.err = 'Что-то пошло не так';
                    }
                    return response.json();
                  })
                  .then((row) => {
                    if (row && row.sections) {
                      sections = row.sections;
                    }
                    if (i < this.count) {
                      i++;
                      stepRow(data.data[i], i);
                    } else {
                      this.isErr = false;
                      this.err = '';
                      this.percentage = 100;
                      this.progress = '';
                    }
                  });
              };

              stepRow(data.data[0], 0);
              //this.isLoading = false;
            } else {
              this.isErr = true;
              this.err = 'Что-то пошло не так';
            }
          });
      } else {
        this.isErr = true;
        this.err = 'Файл не загружен :(';
      }
    },
  },
});
