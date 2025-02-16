<script setup lang="ts">
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";
import { router, usePage, Link } from "@inertiajs/vue3";
import { User } from "@/types";
import { Poll } from "@/types/Poll";

type PollCardProps = {
    poll: Poll;
};

const props = defineProps<PollCardProps>();

const user = usePage().props.auth.user as User | null;

const goToEditPoll = () => {
    localStorage.setItem("editPoll", JSON.stringify(props.poll));
    router.visit(route("polls.edit"));
};

const deletePoll = () => {
    router.delete(route("polls.destroy", { poll: props.poll.id }), {
        onBefore: () => {
            if (!confirm("Are you sure you want to delete this poll?")) {
                return false;
            }
        },
        onSuccess: () => {
            alert("Poll deleted successfully");
        },
        onError: () => {
            alert("Failed to delete poll");
        },
    });
};
</script>

<template>
    <div class="bg-white shadow-md rounded-md p-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ poll.question }}</h2>
            <div
                class="flex items-center gap-2"
                v-if="user?.id === poll.user_id"
            >
                <TrashIcon
                    @click="deletePoll"
                    class="h-5 w-5 text-red-500 cursor-pointer"
                />
                <PencilSquareIcon
                    @click="goToEditPoll"
                    class="h-5 w-5 text-blue-500 cursor-pointer"
                />
            </div>
        </div>
        <p class="text-sm text-gray-500 mb-2">
            {{ poll.options_sum_votes }} votes
        </p>
        <Link
            :href="route('polls.show', { poll: poll.id })"
            class="p-2 text-sm font-medium bg-blue-500 text-white rounded-md"
        >
            View Poll
        </Link>
    </div>
</template>
