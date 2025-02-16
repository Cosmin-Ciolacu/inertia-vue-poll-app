<template>
    <form class="space-y-6" @submit.prevent="submitForm">
        <h1 class="text-2xl font-semibold">Create a Poll</h1>
        <div>
            <div>
                <TextInput
                    v-model="pollForm.question"
                    id="question"
                    name="question"
                    label="Question"
                    placeholder="What is your favorite color?"
                />
                <p v-if="pollForm.errors.question" class="text-red-500 text-sm">
                    {{ pollForm.errors.question }}
                </p>
            </div>
        </div>
        <div>
            <div v-for="(_, index) in pollForm.options" :key="index">
                <div class="w-full flex items-center space-x-2">
                    <TextInput
                        v-model="pollForm.options[index].option"
                        :id="'option' + index"
                        :name="'option' + index"
                        :label="'Option ' + (index + 1)"
                        placeholder="Red"
                    />
                    <TrashIcon
                        @click="pollForm.options.splice(index, 1)"
                        class="h-5 w-5 text-red-500 cursor-pointer"
                    />
                </div>
                <p
                    v-if="
                        pollForm.errors.options &&
                        pollForm.errors.options[index]
                    "
                    class="text-red-500 text-sm"
                >
                    {{ pollForm.errors.options[index] }}
                </p>
            </div>
            <button
                type="button"
                @click="addOption"
                class="mt-2 p-2 text-sm font-medium bg-blue-500 text-white rounded-md"
            >
                Add Option
            </button>
        </div>

        <button
            type="submit"
            class="w-full bg-black text-white py-2 rounded-md"
        >
            {{ isEdit ? "Edit" : "Create" }} Poll
        </button>
    </form>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, onUnmounted } from "vue";
import { TrashIcon } from "@heroicons/vue/24/solid";
import TextInput from "../shared/TextInput.vue";
import { Poll } from "../../types/Poll";
import { useForm } from "@inertiajs/vue3";

const editPollObject = ref<Poll | null>(null);
const pollForm = useForm({
    question: "",
    options: [{ option: "" }, { option: "" }],
});

onMounted(() => {
    const editPollStorage = localStorage.getItem("editPoll");
    if (!editPollStorage) {
        return;
    }

    const editPoll = JSON.parse(editPollStorage) as Poll;
    if (!editPoll) {
        return;
    }

    editPollObject.value = editPoll;
    pollForm.question = editPollObject.value.question;
    pollForm.options = editPollObject.value.options.map((option) => ({
        id: option.id,
        option: option.option,
    }));
});

onUnmounted(() => {
    localStorage.removeItem("editPoll");
});

const isEdit = computed(() => editPollObject.value !== null);

const addOption = () => {
    pollForm.options.push({ option: "" });
};

const submitForm = () => {
    if (isEdit.value) {
        pollForm.put(
            route("polls.update", { poll: editPollObject.value?.id }),
            {
                onSuccess: () => {
                    alert("Poll updated successfully");
                    //   router.push("/");
                },
                onError: () => {
                    alert("Failed to update poll");
                },
            }
        );
    } else {
        pollForm.post(route("polls.store"), {
            onSuccess: () => {
                alert("Poll created successfully");
                pollForm.reset();
                localStorage.removeItem("editPoll");
                //   router.push("/");
            },
            onError: () => {
                alert("Failed to create poll");
            },
        });
    }
};
</script>
