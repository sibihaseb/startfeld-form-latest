<template>
  <div class="editView">
    <div class="header-application">
    <h1 v-show="applicationEditViewState.flag === 'view'">{{ $t("admin.application.applicationEditView.viewTitle") }}</h1>
    <h1 v-show="applicationEditViewState.flag === 'edit'">{{ $t("admin.application.applicationEditView.editTitle") }}</h1>
    <el-button v-show="applicationEditViewState.flag === 'view'" type="primary" @click="onEditClick">
        {{ $t("admin.application.applicationEditView.editApplicationTitle") }}
    </el-button>
    </div>

  </div>
  <wizard
    :token="token"
    :flag="applicationEditViewState.flag"
    :disable="applicationEditViewState.disable"
  />
</template>

<script setup lang="ts">
import { onBeforeMount, reactive } from "vue";
import { useRoute } from "vue-router";
import router  from '../../../router'
import wizard from "@/views/wizard.vue";

const route = useRoute();
const token = route.params.token;
const applicationEditViewState = reactive({
  flag: "",
  disable: false,
});

const onEditClick = () => {
    router.push({ name: "application_edit", params: { token: token } });
}

onBeforeMount(() => {
  if (route.name === "application_view") {
    applicationEditViewState.flag = "view";
    applicationEditViewState.disable = true;
  } else {
    applicationEditViewState.flag = "edit";
    applicationEditViewState.disable = false;
  }
});
</script>

<style lang="scss" scopped>
.header-application{
    display: flex;
    align-content: center;
    align-items: center;
    justify-content: space-between;
}
.editView {
  max-width: 1400px;
  margin: auto;
}
</style>
