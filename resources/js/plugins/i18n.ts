import { createI18n } from 'vue-i18n';
import type { I18nOptions } from 'vue-i18n';
import Cookies from "js-cookie";


//german
import deauth from '../locales/de/auth.json';
import deadmin from '../locales/de/admin.json';
import devalidation from '../locales/de/validation_messages.json';
import delanding from '../locales/de/landing.json';
import delayout from '../locales/de/layout.json';
import dewizard from '../locales/de/wizard.json';

//english
import enauth from '../locales/en/auth.json';
import enadmin from '../locales/en/admin.json';
import envalidation from '../locales/en/validation_messages.json';
import enlanding from '../locales/en/landing.json';
import enlayout from '../locales/en/layout.json';
import enwizard from '../locales/en/wizard.json';

const messages = {
    de: {
        auth: deauth,
        admin: deadmin,
        validation_messages: devalidation,
        layout: delayout,
        wizard: dewizard,
        landing: delanding,
    },
    en: {
        auth: enauth,
        admin: enadmin,
        validation_messages: envalidation,
        layout: enlayout,
        wizard: enwizard,
        landing: enlanding,
    }
};

const numberFormats = {
    CHF: {
        currency: {
            style: "currency",
            currency: "CHF",
            currencyDisplay: "symbol"
        }
    }
};

const datetimeFormats: I18nOptions["datetimeFormats"] = {
    de: {
        short: {
            year: "numeric",
            month: "numeric",
            day: "numeric"
        }
    },
    en: {
        short: {
            year: "numeric",
            month: "numeric",
            day: "numeric"
        }
    },
    fr: {
        short: {
            year: "numeric",
            month: "numeric",
            day: "numeric"
        }
    }
};

let locale = Cookies.get('userLocale') || navigator.language || navigator.language;
locale = locale.split('-')[0];

export const i18n = createI18n({
    legacy: false,
    locale: locale,
    globalInjection: true,
    fallbackLocale: 'en',
    silentTranslationWarn: true,
    messages,
    numberFormats,
    datetimeFormats
});
