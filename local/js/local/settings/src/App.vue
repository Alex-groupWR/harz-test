<script setup>
import { useAccessStore } from '@/store/access';
useAccessStore().getAccess();
</script>

<template>
  <div v-if="isAccess">
    <router-view />
  </div>
  <el-alert
    v-if="!isAccess"
    class="settings-main__alert"
    title="Недостаточно прав доступа"
    show-icon
    :closable="false"
    type="error"
  />
</template>

<script>
import { defineComponent } from 'vue';
import { mapState } from 'pinia';
import { ElAlert } from 'element-plus';

export default defineComponent({
  name: 'App',
  components: {
    ElAlert,
  },
  computed: {
    ...mapState(useAccessStore, {
      isAccess: 'isAccess',
    }),
  },
});
</script>

<style lang="scss">
:root {
  color-scheme: light;
  --el-color-primary: #6c4098 !important;
  --el-color-primary-light-3: grey !important;
  --el-color-primary-light-5: grey !important;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width: 100%;
}

#app *::-webkit-scrollbar {
  width: 3px;
}

#app *::-webkit-scrollbar-track {
  background: #e7edf6;
}

#app *::-webkit-scrollbar-thumb {
  border-radius: 1rem;
  background: orange;
  opacity: 0.6;
}

.el-scrollbar__thumb {
  background: rgb(71, 136, 154) !important;
  opacity: 0.6 !important;
}

.el-scrollbar__bar.is-horizontal {
  height: 3px !important;
}

.el-link.el-link--primary {
  --el-link-text-color: orange !important;
  --el-link-hover-text-color: orange !important;
  --el-link-disabled-text-color: orange !important;
}
.el-link:hover {
  color: orange !important;
  opacity: 0.8;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}

.mb-32 {
  margin-bottom: 32px;
}
</style>
