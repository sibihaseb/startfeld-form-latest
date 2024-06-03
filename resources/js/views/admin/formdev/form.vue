<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection">Add Section</el-button>

        <div v-if="isVisible">
          <div class="section">
            <form-build
              :section="currentSection"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></form-build>
          </div>
        </div>
        <div>
          <h3>Submitted Sections</h3>
          <ul>
            <li
              v-for="(section, index) in submittedSections"
              :key="index"
              @click="showSection(index)"
            >
              Section {{ index + 1 }}
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import formBuild from "@/components/formBuild.vue";
import { ref } from "vue";

const isVisible = ref(false);
const currentSection = ref<Section>({ title: "", type: "", description: "" });
interface Section {
  title: string;
  type: string;
  description: string;
}
const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};

const submittedSections = ref<Section[]>([]);

const onSubmit = (form: Section) => {
  console.log("Form submitted:", form);
  submittedSections.value.push(form);
  isVisible.value = false;
};

const showSection = (index: number) => {
  console.log("Clicked on section:", index);
  currentSection.value = submittedSections.value[index];
  console.log("Current section:", currentSection.value);
};
</script>

<style lang="scss">
.section {
  margin-top: 10px;
}
</style>
