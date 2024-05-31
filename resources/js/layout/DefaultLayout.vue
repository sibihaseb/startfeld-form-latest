<template>

    <div class="wrapper">
        <header>
            <nav>
                <div class="__logo">
                    <img src="../assets/images/logo.png" @click="homeView">
                </div>
                <div class="__buttons" :class="{ hidden: !isVisible, visible: isVisible }">
                    <div class="cancel" @click="hideMenu">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <div class="dropdown__language">
                        <div class="dropdown">
                            <div class="select" @click="toggleDropdown">
                                <span class="selected">{{ selectedOption }}</span>
                                <div class="caret" :class="{ 'caret-rotate': isOpen }"></div>
                            </div>
                            <ul class="menu" :class="{ 'menu-open': isOpen }">
                                <li v-for="option in options" :key="option"
                                    :class="{ 'active': option === selectedOption }" @click="selectOption(option)">
                                    {{ option }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button class="custom-btn sign__in" @click="loginView">Sign In</button>
                    <button class="custom-btn active sign__in" @click="registerView">Sign Up</button>

                </div>
                <div class="hamburger" @click="showMenu">
                    <div class=" line"></div>
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
                <div class="__logo"><img src="../assets/images/logo.png" alt="Fokus Netwokr" @click="homeView"></div>
                <p class="footer__text">Stay updated with the latest from Fokus Network. Follow us on social media or
                    contact us directly for
                    any
                    inquiries.</p>
            </div>
            <div class="col-4">
                <h3>Links</h3>
                <ul class="footer__links">
                    <li>About us</li>
                    <li>How its work</li>
                    <li>Testimonials</li>
                    <li>Contact us</li>
                </ul>
            </div>
            <div class="col-4">
                <h3>Legal information</h3>
                <ul class="footer__links">
                    <li>Privacy Policy</li>
                    <li>Cookies</li>
                    <li>FAQs</li>
                </ul>
            </div>
            <div class="col-4">
                <h3>Get in Touch</h3>
                <ul class="footer__links">
                    <li>
                        <a href="mailto:support@fokusnetwork.com">support@fokusnetwork.com</a>
                    </li>
                    <li>+1-800-123-4567</li>
                    <li class="social__icons">
                        <div><img src="../assets/images/g+.png"></div>
                        <div><img src="../assets/images/utube.png"></div>
                        <div><img src="../assets/images/fb.png"></div>
                        <div><img src="../assets/images/linkedin.png"></div>
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
import { ref } from 'vue';

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
const registerView=()=>
{
    router.push({ name:"wizard"});
}
const isVisible = ref(false);
const showMenu = () => {
    isVisible.value = !isVisible.value;
};
const hideMenu = () => {
    isVisible.value = false;
};
const options = ref(['USA', 'German']); // Replace with your options
const selectedOption = ref('Select a country');
const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const selectOption = (option: string) => {
    selectedOption.value = option;
    isOpen.value = false;
};
</script>

<style lang="scss" scoped>
@use "../assets/scss/colors.scss" as *;

</style>
