<script setup>
import { storeToRefs } from 'pinia';
import { ref } from 'vue';

import { useSettingsStore } from '@/store/settings';

const {
  isLoading,
  language,
  section,
  isDisabled,
  percentage,
  isErr,
  err,
  mode,
  progress,
} = storeToRefs(useSettingsStore());

const printers = {
  actual: 'Принтеры, совместимые с актуальными материалами',
  'part-actual': 'Принтеры, частично совместимые с актуальными материалами',
};
/* eslint-disable */
const file = ref(false);
</script>

<template>
  <div class="settings">
    <h1 class="settings__title">Обновление настроек печати</h1>

    <el-form
      class="settings__form"
      label-width="auto"
      style="max-width: 600px; width: 600px"
    >
      <el-form-item v-if="!isLoading" label="Что загрузжаем?">
        <el-select v-model="mode">
          <el-option label="Настройки" value="settings" />
          <el-option label="Конфигурации" value="config" />
        </el-select>
      </el-form-item>

      <div v-if="!isLoading && mode == 'settings'">
        <el-form-item label="Сайт">
          <el-switch v-model="language" active-text="ru" inactive-text="en" />
        </el-form-item>
        <el-form-item label="Категория">
          <el-select v-model="section">
            <el-option :label="printers.actual" value="actual" />
            <el-option :label="printers['part-actual']" value="part-actual" />
          </el-select>
        </el-form-item>
        <el-form-item label="Файл с настройками">
          <el-upload
            ref="file"
            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            action="/local/js/local/settings/api/file.php"
            class="upload-demo"
            :before-upload="handleBeforeSetFile"
            :on-success="handleSetFile"
            :before-remove="handleRemoveFile"
            :limit="1"
            :auto-upload="true"
          >
            <template #trigger>
              <el-button type="primary">Выберите файл</el-button>
            </template>
            <template #tip>
              <div class="el-upload__tip text-red">
                Для того, чтобы все прошло хорошо - необходимо убрать из эксель
                формулы, скопировав в документ только преобразованные значения,
                и проверить названия(не должно быть русских букв). Также, очень
                важно дождаться загрузки страницы и не перезагружать ее в
                процессе выполнения, не открывать в новой вкладке.
              </div>
            </template>
          </el-upload>
        </el-form-item>

        <el-form-item>
          <el-button
            :disabled="isDisabled"
            type="primary"
            @click="uploadSettings"
            >Загрузить настройки</el-button
          >
        </el-form-item>
      </div>

      <div v-if="!isLoading && mode == 'config'">
<!--        <el-form-item label="Сайт">-->
<!--          <el-checkbox-group v-model="languageConfig">-->
<!--            <el-checkbox value="ru" name="lang">-->
<!--              ru-->
<!--            </el-checkbox>-->
<!--            <el-checkbox value="en" name="lang">-->
<!--              en-->
<!--            </el-checkbox>-->
<!--          </el-checkbox-group>-->
<!--        </el-form-item>-->
        <el-form-item label="Файл с конфигурациями">
          <el-upload
            ref="file"
            accept=".cfg, .cxcfg, .cfgx, .7z, .zip"
            action="/local/js/local/settings/api/config.php"
            class="upload-demo"
            :limit="1"
            :auto-upload="true"
          >
            <template #trigger>
              <el-button type="primary">Выберите файл</el-button>
            </template>
            <template #tip>
              <div class="el-upload__tip text-red">
                Автоматическая загрузка. Важно, что бы название файла было
                идентично символьному коду из экселя. Например, ElegooSaturn.cfg
              </div>
            </template>
          </el-upload>
        </el-form-item>
      </div>

      <div v-if="isLoading && mode == 'settings'">
        <h2 class="settings__mini-title">
          {{ printers[section] }}
          ({{ language ? 'ru' : 'en' }})
        </h2>
        <el-progress :percentage="percentage" />
        <p class="settings__text-progress">{{ progress }}</p>
        <el-alert
          class="settings__alert"
          v-if="percentage == 100"
          title="Загружено"
          type="success"
          :closable="false"
        />
        <el-button
          v-if="percentage == 100"
          class="settings__more"
          type="primary"
          @click="uploadMore"
          >Загрузить еще?</el-button
        >
        <el-alert
          class="settings__alert"
          v-if="isErr"
          :title="err"
          type="failure"
          :closable="false"
        />
      </div>
    </el-form>
  </div>
</template>

<script>
import {
  ElAlert,
  ElForm,
  ElFormItem,
  ElSwitch,
  ElSelect,
  ElOption,
  ElUpload,
  ElButton,
  ElProgress,
  ElCheckboxGroup,
  ElCheckbox
} from 'element-plus';
import { mapActions } from 'pinia';

export default {
  name: 'SettingsMain',
  components: {
    ElAlert,
    ElForm,
    ElFormItem,
    ElSwitch,
    ElSelect,
    ElOption,
    ElUpload,
    ElButton,
    ElProgress,
    ElCheckboxGroup,
    ElCheckbox
  },
  methods: {
    ...mapActions(useSettingsStore, [
      'uploadSettings',
      'uploadMore',
      'setFile',
    ]),
    handleBeforeSetFile(file) {
      console.log(file);
      this.setFile(true);
    },
    handleSetFile(file) {
      console.log(file);
      if (file && !file.error) {
        this.setFile(file);
      } else {
        this.setFile(false);
      }
    },
    handleRemoveFile(file) {
      this.setFile(false);
    },
  },
};
</script>

<style>
.settings {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.settings__title {
  font-size: 36px;
  margin-bottom: 64px;
}

.settings__form {
  padding: 36px;
  border: 1px solid var(--el-border-color);
  border-radius: 16px;
  width: 100%;
}

.el-upload__input {
  display: none !important;
}

.el-upload__tip {
  line-height: 120% !important;
}

.el-switch__label.is-active {
  font-weight: bold;
}

.settings__mini-title {
  margin-bottom: 36px !important;
  display: block !important;
  line-height: 120% !important;
  color: inherit !important;
}

.settings__alert {
  margin-top: 32px !important;
}

.settings__more {
  margin-top: 32px;
  margin-left: auto;
  margin-right: auto;
}
</style>
