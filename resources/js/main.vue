<template>
    <component :is="$route.meta.layout">
      <RouterView :key="$route.fullPath" />
    </component>
  </template>

  <script setup lang="ts"></script>
