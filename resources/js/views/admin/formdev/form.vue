<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection">Add Questions</el-button>
        <div>
          <p>
            Submitted Section : {{ submittedSections }}
          </p>
        </div>
        <div v-if="isVisible">
          <div class="section">
            <add-field
              :section="currentSection"
              :step="submittedSections"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <display-form :section="submittedSections"></display-form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import formBuild from "@/components/formBuild.vue";
import { ref } from "vue";
import addField from "@/components/addField.vue"; // Import the displayForm component

interface Section {
  title: string;
  type: string;
  description: string;
  step: string;
  options: string;
  minValue: string;
  maxValue: string;
  dateFormat: string;
  protocol: string;
}

const isVisible = ref(false);
const currentSection = ref<Section>({
  title: "",
  description: "",
  type: "",
  step: "",
  options: "",
  minValue: "",
  maxValue: "",
  dateFormat: "",
  protocol: "",
});
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
  isVisible.value = !isVisible.value;
  console.log("Current section:", currentSection.value);
};
</script>

<style lang="scss">
.section {
  margin-top: 10px;
}
</style>
