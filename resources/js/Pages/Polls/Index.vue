<script setup lang="ts">
import {Poll} from "@/types/Poll";
import EmptyState from "@/Components/UI/EmptyState.vue";
import PollsGrid from "@/Components/Polls/PollsGrid.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

type PollsIndexProps = {
    polls: Poll[]
}

defineProps<PollsIndexProps>()
</script>

<template>
    <AuthenticatedLayout>
        <div class="mt-8">
            <h1 class="text-3xl font-semibold text-gray-900">Polls</h1>
            <EmptyState
                v-if="polls.length === 0"
                title="No Polls Found"
                description="There are no polls available at the moment."
            />
            <PollsGrid v-else :polls="polls" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
