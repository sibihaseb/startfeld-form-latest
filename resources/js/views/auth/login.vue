<template>
  <div class="main-view">
    <div class="auth-layout">
      <h1 class="title side-pink-dot-bar">{{ $t("auth.login.title") }}</h1>
      <el-form
        require-asterisk-position="right"
        :model="loginForm"
        ref="loginFormRef"
        :rules="rules"
        label-position="top"
      >
        <el-form-item :label="$t('auth.login.labelInputEmail')" prop="email">
          <el-input
            size="large"
            type="email"
            v-model="loginForm.email"
            :placeholder="$t('auth.login.emailPlaceholder')"
          />
        </el-form-item>
        <el-form-item :label="$t('auth.login.labelInputPassword')" prop="password">
          <el-input
            @keyup.enter="loginFormSubmit(loginFormRef)"
            size="large"
            type="password"
            v-model="loginForm.password"
            :placeholder="$t('auth.login.passwordPlaceholder')"
          />
        </el-form-item>
        <div>
          <label class="labelofRemember" for="loginFormRemember">{{
            $t("auth.login.labelInputRememberMe")
          }}</label>
          <el-checkbox
            id="loginFormRemember"
            class="remember-me"
            size="large"
            v-model="loginForm.remember"
            :placeholder="$t('auth.login.passwordPlaceholder')"
          ></el-checkbox>
        </div>
        <span v-show="state.errorMsg" class="error-authform">{{ state.errorMsg }}</span>

        <div class="btactions">
          <RouterLink class="link" :to="{ name: 'forgot_password' }">{{
            $t("auth.login.forgotPasswordButtonText")
          }}</RouterLink>
          <el-button type="primary" @click="loginFormSubmit(loginFormRef)">
            {{ $t("auth.login.loginButtonText") }}
          </el-button>
        </div>
      </el-form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import type { Auth_Login } from "../../client";
import { useAuthStore } from "../../store/storeAuth";
import type { FormInstance, FormRules } from "element-plus";
import { useI18n } from "vue-i18n";
import router from "../../router/index";

const { t } = useI18n();
const i18nLocale = useI18n();
const authStore = useAuthStore();
const loginFormRef = ref<FormInstance>();

const state = reactive({
  errorMsg: "",
  loading: false,
});

const loginForm: Auth_Login | undefined = reactive({
  email: "",
});

const rules = reactive<FormRules>({
  email: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
    {
      type: "email",
      message: t("validation_messages.email"),
      trigger: "blur",
    },
  ],
  password: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],
});

const redirectUser = async () => {
  await authStore
    .authUser()
    .then(() => {
      router.push({
        name: "application",
      });
    })
    .catch((error) => {
      state.errorMsg = error.data.message;
    });
};

const loginFormSubmit = (formEl: FormInstance | undefined) => {
  if (!formEl) {
    return;
  }
  formEl.validate((valid) => {
    if (valid) {
      state.loading = true;
      authStore
        .login(loginForm, i18nLocale.locale.value)
        .then(() => {
          state.errorMsg = "";
          state.loading = false;
          redirectUser();
        })
        .catch((error) => {
          state.loading = false;
          state.errorMsg = error.response.data.message;
        });
    }
  });
};
</script>

<style lang="scss" scoped>
.remember-me {
  margin-left: 5px;
}
</style>
