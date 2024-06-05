<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection"
          >Add Questions</el-button
        >
        <div>
          <p>Submitted Section: {{ submittedSections }}</p>
        </div>
        <div v-if="isVisible">
          <div class="section">
            <add-field
              :step="submittedSections"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <display-form
          :questions="submittedSections"
        ></display-form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import AddField from "@/components/addField.vue";
import DisplayForm from "@/components/wizardView.vue";

const isVisible = ref(false);
const submittedSections = ref<any[]>([]);

const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};

const onSubmit = (form: any) => {
  form.step = submittedSections.value.length + 1; // Set the step value
  submittedSections.value.push({ ...form });
  toggleFormSection();
};
</script>
