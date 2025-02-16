<script setup lang="ts">
import { PollOption } from "@/types/PollOption";
import { computed } from "vue";

type PollOptionWithPercentageProps = {
    option: PollOption;
    totalVotes: number;
};

const props = defineProps<PollOptionWithPercentageProps>();

const percentage = computed(() => {
    if (props.totalVotes === 0) {
        return "0.00";
    }
    return parseInt(((props.option.votes / props.totalVotes) * 100).toString());
});
</script>

<template>
    <p class="font-medium">{{ props.option.option }}</p>
    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
        <div
            class="bg-blue-500 h-4 rounded-full"
            :style="{ width: `${percentage}%` }"
        ></div>
    </div>
    <p class="text-sm text-gray-600">{{ percentage }}%</p>
</template>
