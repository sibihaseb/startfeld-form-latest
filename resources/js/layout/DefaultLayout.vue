<template>
  <header>
    <div class="main-view">
      <div class="header-content">
        <!-- <img class="click-icon" src="../assets/images/STARTFELD.svg" @click="homeView" /> -->
        <a class="click-icon logo-main" src="../assets/images/STARTFELD.svg" @click="homeView">Company</a>
        <i class="ri-user-line ri-lg space-top click-icon" :title="authStore.me?.firstname
            ? authStore.me?.firstname + ' ' + authStore.me?.lastname
            : $t('layout.defaultLayout.labelLogin')
          " @click="loginView"></i>
      </div>
    </div>
  </header>
  <main class="maincontent">
    <RouterView :key="$route.path" />
  </main>
  <footer>
    <div>
      <div class="overlay-footer"></div>
      <div class="elementor-shape">
        <svg class="footer-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
          <path class="elementor-shape-fill" d="M737.9,94.7L0,0v100h1000V0L737.9,94.7z"></path>
        </svg>
      </div>
    </div>
    <div class="main-view">
      <div class="footer-content">
        <div class="footer-column-info">
          <router-link to=""><a class="click-icon logo-main" src="../assets/images/STARTFELD.svg">Company</a></router-link>
          <h4>Designed By Sibi Haseb</h4>
          <p>Full Stack Developer</p>
          <h4><a class="link" href="mailto:info@sibihaseb.com">info@sibihaseb.com</a></h4>
        </div>
      </div>
      <div class="copyright-row">
        <p>© 2024 Sibihaseb.com</p>
        <el-select class="language-select" size="small" v-model="i18nLocale.locale.value" @change="setLocale">
          <el-option v-for="(lang, i) in i18nLocale.availableLocales" :key="i" :value="lang"
            :label="$t('admin.footer.language.' + lang)">
            {{ $t("admin.footer.language." + lang) }}
          </el-option>
        </el-select>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import router from "../router";
import { useAuthStore } from "../store";
import { useI18n } from "vue-i18n";
import Cookies from "js-cookie";

const authStore = useAuthStore();
const i18nLocale = useI18n();

const setLocale = (item: string) => {
  var inFifteenMinutes = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 1);
  Cookies.set("userLocale", item, {
    expires: inFifteenMinutes,
  });
};

const homeView = () => {
  router.push({ name: "wizard" });
};

const loginView = () => {
  router.push({ name: "login" });
};
</script>

<style lang="scss" scoped>
@use "../assets/scss/colors.scss" as *;

.space-top {
  margin-top: 20px;
}

.elementor-shape {
  overflow: hidden;
  left: 0;
  width: 100%;
  height: 100px;
  direction: ltr;
}

.footer-svg {
  top: 50%;
  display: block;
  width: 100%;
  position: relative;
  height: 50px;
  left: 50%;
  transform: translateX(-50%);
}

.elementor-shape-fill {
  fill: $footer-svg-color;
}

.overlay-footer {
  background-image: url("@/assets/images/lines-black.png");
  background-size: 206px auto;
  opacity: 0.15;
  transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
  height: 100px;
  width: 100%;
  position: absolute;
}

.footer-content p {
  display: block;
  margin-block-start: 0em;
  margin-block-end: 0em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
}

.footer-content h4 {
  display: block;
  margin-block-start: 0.33em;
  margin-block-end: 0.33em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-weight: bold;
}

.footer-column-info {
  flex-direction: column;
  max-width: 150px;
}

.copyright-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.language-select {
  max-width: 100px;
}

.logo-main{
    font-size: x-large;
}
</style>
