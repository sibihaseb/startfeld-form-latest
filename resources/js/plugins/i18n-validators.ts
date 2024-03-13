import * as validators from '@vuelidate/validators'
import {i18n} from './i18n';

// or import { createI18nMessage } from '@vuelidate/validators'
const { createI18nMessage } = validators

// Create your i18n message instance. Used for vue-i18n@9
const messagePath = ({ $validator }) => `validation_messages.${$validator}`;
const withI18nMessage = createI18nMessage({ t: i18n.global.t.bind(i18n),messagePath })
// for vue-i18n@8
// const withI18nMessage = createI18nMessage({ t: i18n.t.bind(i18n) })
export const minLength = withI18nMessage(validators.minLength(8));
export const maxLength = withI18nMessage(validators.maxLength(255));
// wrap each validator.
export const required = withI18nMessage(validators.required)
// validators that expect a parameter should have `{ withArguments: true }` passed as a second parameter, to annotate they should be wrapped
export const email = withI18nMessage(validators.email);
// or you can provide the param at definition, statically
