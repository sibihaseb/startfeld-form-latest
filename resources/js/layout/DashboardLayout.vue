<template>
  <header>
    <div class="main-view">
      <div class="header-content">
        <RouterLink :to="{ name: 'landingPage' }"
          ><img
            class="click-icon logo"
            width="150"
            height="50"
            src="../assets/images/FokusLogo.svg"
            @click="home"
          />
        </RouterLink>

        <div class="nav-bar">
          <h3 class="space-top greeting">
            {{ $t("layout.dashboardLayout.welcomeMessage") }},
            {{ authStore.me?.lastname }} {{ authStore.me?.firstname }}
          </h3>

          <div class="space-top space-left">
            <el-dropdown :disabled="headerState.loading" @command="handleCommand">
              <i
                :title="$t('layout.dashboardLayout.labelNotification')"
                v-if="authStore.me?.notification"
                class="ri-notification-line ri-lg color-green click-icon"
              ></i>
              <i
                v-else
                :title="$t('layout.dashboardLayout.labelNotification')"
                class="ri-notification-off-line ri-lg bold click-icon"
              ></i>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item :command="1">{{
                    $t("layout.dashboardLayout.labelNotificationOn")
                  }}</el-dropdown-item>
                  <el-dropdown-item :command="0">{{
                    $t("layout.dashboardLayout.labelNotificationOff")
                  }}</el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
          <RouterLink :to="{ name: 'application' }" class="nav-item space-left space-top">
            <i
              class="ri-file-list-3-line ri-lg"
              :title="$t('layout.dashboardLayout.labelApplicationManagement')"
            ></i>
          </RouterLink>
          <RouterLink
            v-if="authStore.me?.role === 'superadmin'"
            :to="{ name: 'user_management' }"
            class="nav-item space-left space-top"
            ><i
              class="ri-user-settings-line ri-lg"
              :title="$t('layout.dashboardLayout.labelUserManagement')"
            ></i>
          </RouterLink>
          <RouterLink
            v-if="authStore.me?.role === 'superadmin'"
            :to="{ name: 'form_bulid' }"
            class="nav-item space-left space-top"
            ><i
              class="ri-survey-line ri-lg"
              :title="$t('layout.dashboardLayout.labelFormDevelopment')"
            ></i>
          </RouterLink>
          <RouterLink :to="{ name: 'profile' }" class="nav-item space-left space-top">
            <i
              class="ri-settings-2-line ri-lg"
              :title="$t('layout.dashboardLayout.labelProfileSetting')"
            ></i>
          </RouterLink>
          <i
            class="ri-logout-box-r-line ri-lg click-icon logout space-left space-top"
            :title="$t('layout.dashboardLayout.labelLogout')"
            @click="logout"
          ></i>
        </div>
      </div>
    </div>
  </header>
  <main class="maincontent">
    <RouterView class="content-inside" :key="$route.path" />
  </main>
  <footer class="footer">
    <div>
      <div class="elementor-shape">
        <svg
          class="footer-svg"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1000 100"
          preserveAspectRatio="none"
        >
          <path
            class="elementor-shape-fill"
            d="M737.9,94.7L0,0v100h1000V0L737.9,94.7z"
          ></path>
        </svg>
      </div>
    </div>
    <div class="footer-view">
      <div class="copyright-row">
        <p>© 2024 FOKUS NETWORK</p>
        <!-- <p>
          &nbsp;{{ $t("layout.dashboardLayout.footer.poweredBy") }} &nbsp;
          <a class="link" href="https://www.xtendum.com/" target="_blank">xtendum</a>
        </p> -->
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import router from "../router";
import { useAuthStore } from "../store";
import { ElMessage } from "element-plus";
import { userService } from "../client";
import type { User } from "../client";
import { reactive } from "vue";

const authStore = useAuthStore();

const headerState = reactive({
  loading: false,
});

const handleCommand = (command: string) => {
  headerState.loading = true;
  let formData = new FormData();
  formData.append("notification", command);
  if (authStore.me?.id) {
    userService
      .updateNotification(formData, authStore.me?.id)
      .then((response: User) => {
        authStore.setUser(response);
        headerState.loading = false;
      })
      .catch((error) => {
        ElMessage({
          type: "error",
          message: error,
        });
        headerState.loading = false;
      });
  }
  headerState.loading = false;
};

const logout = () => {
  authStore.logoutUser().then(() => {
    router.push({ name: "wizard" });
  });
};

const home = () => {
  router.push({ name: "wizard" });
};
</script>

<style lang="scss" scoped>
@use '../assets/scss/colors.scss' as *;
.logo {
  fill: $primary;
}
.nav-bar {
  display: flex;
}
.space-top {
  margin-top: 20px;
}

.space-left {
  margin-left: 15px;
}

.color-green {
  font-weight: bold;
  color: $primary;
}
.bold {
  font-weight: bold;
}

.nav-item {
  text-decoration: none;
}

.logout {
  font-weight: bold;
}
@media screen and (max-width: 860px) {
  .logo {
    width: 100px;
    height: 60px;
  }

  .greeting {
    font-size: small;
  }
}
@media screen and (max-width: 400px) {
  .logo {
    width: 58px;
    height: 50px;
  }

  .greeting {
    font-size: small;
  }
}

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
.maincontent {
  min-height: calc(100vh - 250px);
}
.copyright-row {
  display: flex;
  padding-top: 10px;
  justify-content: space-between;
}
.footer-view {
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}
</style>
