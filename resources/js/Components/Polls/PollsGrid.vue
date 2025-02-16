<script setup lang="ts">
import PollCard from "./PollCard.vue";
import {Poll} from "@/types/Poll";

type PollsGridProps = {
  polls: Poll[];
};

defineProps<PollsGridProps>();
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <PollCard v-for="poll in polls" :key="poll.id" :poll="poll" />
  </div>
</template>
