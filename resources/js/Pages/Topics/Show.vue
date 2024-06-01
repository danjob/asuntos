<template>
    <AppLayout>
        <v-card elevation="2" class="pa-8">
            <v-form ref="form" v-model="valid" lazy-validation>
                <!-- title -->
                <v-row>
                    <v-col>
                        <v-textarea
                            v-model="form.title"
                            :counter="maxTitleLength"
                            :rules="titleRules"
                            label="Your asunto"
                            no-resize
                            required
                        ></v-textarea>
                    </v-col>
                </v-row>

                <!-- categories -->
                <v-row class="mt-6">
                    <v-col>
                        <v-sheet>
                            <v-item-group v-model="form.category_id">
                                <v-item
                                    v-for="(category, i) in this.categories"
                                    :key="i"
                                    v-slot="{ active, toggle }"
                                >
                                    <v-btn
                                        class="m-2"
                                        :input-value="active"
                                        active-class="asuntoBlue"
                                        depressed
                                        rounded
                                        @click="toggle"
                                    >
                                        {{ category.name }}
                                    </v-btn>
                                </v-item>
                            </v-item-group>
                        </v-sheet>
                    </v-col>
                </v-row>

                <!-- submit buttons -->
                <v-row class="mt-16">
                    <v-col>
                        <v-btn
                            class="mt-1"
                            :small="$vuetify.breakpoint.mobile"
                            dark
                            v-if="isEditMode"
                            color="#FB68B7"
                            @click="sheet = !sheet"
                        >
                            Delete
                        </v-btn>

                        <Link
                            class="mt-1"
                            :small="$vuetify.breakpoint.mobile"
                            as="v-btn"
                            color="#F8D550"
                            dark
                            :href="route('topics.index')"
                        >
                            Cancel
                        </Link>

                        <v-btn
                            v-if="!isSubmitTopic"
                            class="mt-1 white--text"
                            :small="$vuetify.breakpoint.mobile"
                            :disabled="!valid"
                            color="#9AD770"
                            @click="submitTopic"
                        >
                            Save
                        </v-btn>

                        <v-progress-circular
                            v-if="isSubmitTopic"
                            indeterminate
                            color="green"
                            class="ml-5"
                        ></v-progress-circular>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>

        <!-- delete sheet -->
        <template>
            <div class="text-center">
                <v-bottom-sheet v-model="sheet">
                    <v-sheet class="text-center" height="200px">
                        <div class="pt-3">Are you sure?</div>
                        <v-btn
                            class="mt-6"
                            text
                            color="error"
                            @click="deleteTopic"
                        >
                            Yes
                        </v-btn>
                        <v-btn
                            class="mt-6"
                            text
                            color="success"
                            @click="sheet = !sheet"
                        >
                            No
                        </v-btn>
                    </v-sheet>
                </v-bottom-sheet>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Link } from "@inertiajs/inertia-vue";

export default {
    components: {
        AppLayout,
        Link,
    },

    mounted() {
        if (this.isEditMode) {
            this.form = this.topic;

            if (this.topic.category) {
                this.form.category_id = this.topic.category.id - 1;
            }
        }

        this.valid = false;
    },

    props: ["categories", "topic", "status"],

    data: () => ({
        sheet: false,

        isSubmitTopic: false,

        maxTitleLength: 280,

        form: {
            title: null,
            category_id: [],
        },

        valid: false,

        titleRules: [
            (v) => !!v || "Asunto is needed",
            (v) =>
                (v && v.length <= 280) ||
                "Asunto must have less then 280 characters",
        ],
    }),

    methods: {
        submitTopic() {
            this.isSubmitTopic = true;

            if (this.isEditMode) {
                this.$inertia.put(
                    route("topics.update", this.topic.id),
                    this.form
                );

                return true;
            }

            this.$inertia.post(route("topics.store"), this.form);
        },

        deleteTopic() {
            if (this.isEditMode) {
                this.$inertia.delete(route("topics.destroy", this.topic.id));
            }
        },
    },

    computed: {
        isEditMode() {
            return this.status === "edit";
        },
    },
};
</script>

<style scoped>
.v-textarea >>> .v-text-field__slot {
    border: none;
    overflow: auto;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}
</style>
