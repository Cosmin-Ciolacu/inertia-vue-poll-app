<script setup lang="ts">
import PollForm from "@/Components/forms/PollForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <PollForm />
    </AuthenticatedLayout>
</template>
