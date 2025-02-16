<script setup lang="ts">
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Poll } from "@/types/Poll";
import PollOptionWithPercentage from "@/Components/Polls/PollOptionWithPercentage.vue";
import { router } from "@inertiajs/vue3";

type PollWithHasVoted = Poll & { has_voted: boolean };

type ShowPollProps = {
    poll: PollWithHasVoted;
};

const props = defineProps<ShowPollProps>();

const selectedOption = ref<number | null>(null);
const hasVoted = ref(props.poll.has_voted || false);

const vote = () => {
    if (selectedOption.value !== null) {
        router.post(
            route("polls.vote", { poll: props.poll.id }),
            {
                option_id: selectedOption.value,
            },
            {
                onSuccess: () => {
                    hasVoted.value = true;
                },
                onError: () => {
                    alert("Failed to vote");
                },
            }
        );
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">{{ poll.question }}</h1>

            <div v-if="hasVoted">
                <PollOptionWithPercentage
                    v-for="option in poll.options"
                    :key="option.id"
                    :option="option"
                    :totalVotes="poll.options_sum_votes"
                    class="mb-4"
                />
            </div>

            <div v-else>
                <div
                    v-for="option in poll.options"
                    :key="option.id"
                    class="mb-4"
                >
                    <label class="flex items-center">
                        <input
                            type="radio"
                            :value="option.id"
                            v-model="selectedOption"
                            class="mr-2"
                        />
                        {{ option.option }}
                    </label>
                </div>
                <button
                    v-if="!hasVoted"
                    @click="vote"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Vote
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
