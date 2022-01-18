<template>
    <div class="space-x-1">

    <label for="all">All</label>
      <input
      type="checkbox"
      id="all"
      v-model="allSelected"
      @click="checkAllTasks(allSelected)"

       />
    </div>
</template>

<script setup>

import { inject, ref } from "vue";

const allSelected = ref(false);

const tasks = inject('tasks');

function checkAllTasks(allSelected)
{
    tasks.value = tasks.value.map(task => ({...task, selected: !allSelected }));
}


</script>
