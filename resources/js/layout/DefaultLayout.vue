<template>
  <div class="wrapper">
    <header>
      <nav>
        <div class="__logo">
          <img src="../assets/images/logo.png" @click="homeView" />
        </div>
        <div class="__buttons" :class="{ hidden: !isVisible, visible: isVisible }">
          <div class="cancel" @click="hideMenu">
            <i class="ri-close-fill"></i>
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
            {{ $t("landing.header.signIn") }}
          </button>
          <button class="custom-btn active sign__in" @click="registerView">
            {{ $t("landing.header.signUp") }}
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
          <img src="../assets/images/logo.png" alt="Fokus Netwokr" @click="homeView" />
        </div>
        <p class="footer__text">
          {{ $t("landing.footer.logoDesc") }}
        </p>
      </div>
      <div class="col-4">
        <h3>{{ $t("landing.footer.links") }}</h3>
        <ul class="footer__links">
          <li>{{ $t("landing.footer.aboutUs") }}</li>
          <li>{{ $t("landing.footer.howItWorks") }}</li>
          <li>{{ $t("landing.footer.testimonials") }}</li>
          <li>{{ $t("landing.footer.contactUs") }}</li>
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
            <a href="mailto:support@fokusnetwork.com">support@fokusnetwork.com</a>
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
  var inFifteenMinutes = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 1);
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
@import "../assets/scss/colors";

.container {
  background: $primaryheader;
  width: 100%;
  min-height: 80vh;
}

.wrapper {
  background: $primaryheader;
  position: relative;
}
header {
  width: 100%;
  padding: 1rem;
}
nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 90%;
  margin: auto;
}
.__logo {
  width: 220px;
}
.__logo img {
  width: 100%;
  cursor: pointer;
}
.__buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-family: "GraphikRegular";
}
.dropdown {
  position: relative;
}
.select {
  padding: 12px 30px;
  background: $white;
  border-radius: 24px;
  color: $text-color;
  font-family: "GraphikRegular";
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-family: "GraphikRegular";
  box-shadow: 0px 0px 19.15px 0px rgba(0, 219, 192, 0.2);
}
.select-clicked {
  border: 2px #26489a solid;
  box-shadow: 0 0 0.8em #26489a;
}

.caret {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 6px solid $text-color;
  transition: 0.3s;
}
.caret-rotate {
  transform: rotate(180deg);
}
.menu {
  list-style: none;
  padding: 0.2em 0.5em;
  background: $white;
  border-radius: 0.5em;
  color: $text-color;
  position: absolute;
  top: 4em;
  left: 50%;
  width: 200px;
  transform: translateX(-50%);
  opacity: 0;
  display: none;
  transition: 0.2s;
  z-index: 1;
}
.menu li {
  padding: 0.7em 0.5em;
  margin: 0.3em 0;
  border-radius: 0.5em;
  cursor: pointer;
}
.menu li:hover {
  background: $text-color;
  color: $white;
}
.active {
  background: $text-color;
  color: $white;
}
.menu-open {
  display: block;
  opacity: 1;
  border: 1px solid #eee;
  z-index: 9;
}
.hamburger {
  padding: 1rem;
  background-color: $text-color;
  border-radius: 8px;
  display: none;
}
.hamburger .line {
  margin-bottom: 4px;
  width: 20px;
  height: 2px;
  background-color: $white;
  cursor: pointer;
}
.cancel {
  display: none;
}

footer {
  width: 90%;
  margin: auto;
  border-top: 1px solid rgba(43, 42, 76, 0.2);
  padding-top: 2rem;
}

footer .col-4 {
  flex-basis: 25%;
  display: flex;
  flex-direction: column;
  gap: 3rem;
}
footer .col-4:first-child {
  flex-basis: 35%;
}

footer .row {
  display: flex;
  // padding: 2% 5%;
  justify-content: center;
}
footer .logo {
  width: 250px;
}
footer .logo img {
  width: 100%;
}
.social__icons {
  display: flex;
  gap: 1.5rem;
}
.social__icons > div {
  width: 50px;
  margin-top: 1.7rem;
}
.social__icons > div img {
  box-shadow: 0px 0px 19.15px 0px rgb(19 255 226 / 59%);
  width: 100%;
  border-radius: 50%;
  padding: 0.3rem;
  cursor: pointer;
}
.cc {
  padding: 1rem;
  opacity: 0.5;
  max-width: 90%;
  margin-inline: auto;
}
.cc p {
  text-align: center;
}
.footer__text {
  width: 90%;
}
.footer__links a {
  color: $text-color;
  text-decoration: none;
}
</style>
