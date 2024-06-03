<template>
  <div class="wrapper">
    <header>
      <nav>
        <div class="__logo">
          <img src="../assets/images/logo.png" @click="homeView" />
        </div>
        <div
          class="__buttons"
          :class="{ hidden: !isVisible, visible: isVisible }"
        >
          <div class="cancel" @click="hideMenu">
            <i class="fa-solid fa-xmark"></i>
          </div>
          <div class="dropdown__language">
            <div class="dropdown">
              <el-select
                class="language-select select"
                size="small"
                v-model="i18nLocale.locale.value"
                @change="setLocale"
              >
                <el-option
                  v-for="(lang, i) in i18nLocale.availableLocales"
                  :key="i"
                  :value="lang"
                  :label="$t('admin.footer.language.' + lang)"
                >
                  {{ $t("admin.footer.language." + lang) }}
                </el-option>
              </el-select>
            </div>
          </div>
          <button class="custom-btn sign__in" @click="loginView">
            {{ $t("landing.header.signIn")}}
          </button>
          <button class="custom-btn active sign__in" @click="registerView">
            {{ $t("landing.header.signUp")}}
          </button>
        </div>
        <div class="hamburger" @click="showMenu">
          <div class="line"></div>
          <div class="line"></div>
          <div class="line"></div>
        </div>
      </nav>
    </header>
  </div>

  <main class="maincontent">
    <RouterView :key="$route.path" />
  </main>
  <footer>
    <div class="row">
      <div class="col-4">
        <div class="__logo">
          <img
            src="../assets/images/logo.png"
            alt="Fokus Netwokr"
            @click="homeView"
          />
        </div>
        <p class="footer__text">
          {{ $t("landing.footer.logoDesc") }}
        </p>
      </div>
      <div class="col-4">
        <h3>{{ $t("landing.footer.links") }}</h3>
        <ul class="footer__links">
          <li>{{ $t("landing.footer.aboutUs") }}</li>
          <li>{{ $t("landing.footer.howItWorks")}}</li>
          <li>{{ $t("landing.footer.testimonials")}}</li>
          <li>{{ $t("landing.footer.contactUs")}}</li>
        </ul>
      </div>
      <div class="col-4">
        <h3>{{ $t("landing.footer.legalInformation") }}</h3>
        <ul class="footer__links">
          <li>{{ $t("landing.footer.privacyPolicy") }}</li>
          <li>{{ $t("landing.footer.cookies") }}</li>
          <li>{{ $t("landing.footer.faqs") }}</li>
        </ul>
      </div>
      <div class="col-4">
        <h3>{{ $t("landing.footer.getInTouch") }}</h3>
        <ul class="footer__links">
          <li>
            <a href="mailto:support@fokusnetwork.com"
              >support@fokusnetwork.com</a
            >
          </li>
          <li>+1-800-123-4567</li>
          <li class="social__icons">
            <div><img src="../assets/images/g+.png" /></div>
            <div><img src="../assets/images/utube.png" /></div>
            <div><img src="../assets/images/fb.png" /></div>
            <div><img src="../assets/images/linkedin.png" /></div>
          </li>
        </ul>
      </div>
    </div>
  </footer>

  <div class="cc">
    <p>Copyright by Fokus Network. All Rights Reserved</p>
  </div>
</template>

<script setup lang="ts">
import router from "../router";
import { useAuthStore } from "../store";
import { useI18n } from "vue-i18n";
import Cookies from "js-cookie";
import { ref } from "vue";

const authStore = useAuthStore();
const i18nLocale = useI18n();

const setLocale = (item: string) => {
  var inFifteenMinutes = new Date(
    new Date().getFullYear(),
    new Date().getMonth() + 1,
    1
  );
  Cookies.set("userLocale", item, {
    expires: inFifteenMinutes,
  });
};

const homeView = () => {
  router.push({ name: "landingPage" });
};

const loginView = () => {
  router.push({ name: "login" });
};
const registerView = () => {
  router.push({ name: "wizard" });
};
const isVisible = ref(false);
const showMenu = () => {
  isVisible.value = !isVisible.value;
};
const hideMenu = () => {
  isVisible.value = false;
};
</script>

<style lang="scss" scoped>
@use "../assets/scss/colors.scss" as *;
</style>
