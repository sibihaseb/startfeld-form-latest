<template>
  <div class="applicant">
    <el-form :model="form" label-width="auto">
      <el-form-item label="Title">
        <el-input v-model="form.title" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="form.description" />
      </el-form-item>
      <el-form-item label="Type">
        <el-select v-model="form.type" placeholder="please select field type">
          <el-option label="Text" value="text" />
          <el-option label="Radio" value="radio" />
          <el-option label="Checkbox" value="checkbox" />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Save</el-button>
        <el-button @click="cancelSection">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script lang="ts" setup>
import { reactive } from "vue";
import { defineProps, defineEmits } from "vue";

const { section } = defineProps();
const emit = defineEmits();

const form = reactive({
  title: "",
  description:"",
  type: "",
});
const cancelSection = () => {
  emit("cancel");
};
const onSubmit = () => {
  console.log("submit!");
  emit("submit", form);
};
</script>
