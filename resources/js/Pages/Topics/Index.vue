<template>
    <AppLayout>
        <v-row dense class="row-wrapper">
            <v-col v-for="(topic, i) in topicsSorted" :key="i" cols="12">
                <v-card
                    class="rounded-xl mt-5"
                    :color="stateByCategory(topic).color"
                    dark
                >
                    <v-row class="d-flex flex-no-wrap justify-space-between">
                        <!-- title -->
                        <v-col cols="12" class="pb-0 mb-0">
                            <v-card-title
                                class="text-h5 pb-0 mb-0"
                                v-text="topic.title"
                            ></v-card-title>
                        </v-col>

                        <!-- owners name -->
                        <v-col cols="12">
                            <v-card-subtitle
                                class="blue--text text-darken-4 py-0 my-0"
                            >
                                <span class="white--text">
                                    {{ topic.owner_name }} / {{ topic.created_at }}
                                </span>
                            </v-card-subtitle>
                        </v-col>
                    </v-row>

                    <v-card-actions>
                        <v-list-item class="grow d-flex align-baseline">
                            <v-row align="center" justify="start">
                                <!-- category -->
                                <template v-if="topic.category">
                                    <v-icon class="mr-1">{{
                                        stateByCategory(topic).icon
                                    }}</v-icon>
                                    <span class="subheading mr-2">
                                        {{ topic.category.name }}
                                    </span>
                                </template>
                            </v-row>

                            <v-row align="center" justify="end">
                                <!-- edit -->
                                <v-btn
                                    v-if="user.id == topic.owner_id"
                                    icon
                                    @click="editTopic(topic)"
                                >
                                    <v-icon dark> mdi-pencil </v-icon>
                                </v-btn>

                                <!-- likes -->
                                <v-btn
                                    icon
                                    color="pink"
                                    @click="toggleLike(topic)"
                                >
                                    <v-icon v-if="topic.isLiked">
                                        mdi-heart
                                    </v-icon>
                                    <v-icon v-else> mdi-heart-outline </v-icon>
                                </v-btn>
                                <span class="subheading mr-2">{{
                                    topic.likesCount
                                }}</span>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-bottom-sheet v-model="sheet" hide-overlay>
            <v-alert
                type="success"
                class="ma-0 text-center d-flex justify-center"
            >
                {{ status }}
            </v-alert>
        </v-bottom-sheet>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout,
    },

    mounted() {
        this.showStatusBar();

        this.reloadInterval = setInterval(this.reloadTopics, 10000);
    },

    beforeDestroy() {
        clearInterval(this.reloadInterval);
    },

    data: () => ({
        reloadInterval: null,
        sheet: false,
    }),

    props: ["topics", "status"],

    methods: {
        reloadTopics() {
            this.$inertia.get(
                route("topics.index"),
                {},
                {
                    preserveScroll: true,
                }
            );
        },

        editTopic(topic) {
            this.$inertia.get(
                route("topics.edit", topic.id),
                {},
                {
                    preserveScroll: true,
                }
            );
        },

        toggleLike(topic) {
            this.$inertia.put(
                route("topics.toggle-like", topic.id),
                {},
                {
                    preserveScroll: true,
                }
            );
        },

        showStatusBar() {
            if (this.status) {
                this.sheet = true;

                setTimeout(() => {
                    this.sheet = false;
                }, 2000);
            }
        },

        stateByCategory(topic) {
            if (topic.category) {
                switch (topic.category.id) {
                    case 1:
                        return { color: "#F8D550", icon: "mdi-hands-pray" };

                    case 2:
                        return { color: "#9AD770", icon: "mdi-flare" };

                    case 3:
                        return { color: "#FB68B7", icon: "mdi-handshake" };
                }
            }

            return { color: "#26c6da" };
        },
    },

    computed: {
        topicsSorted() {
            return _.orderBy(this.topics, "likes", "desc");
        },

        user() {
            return this.$page.props.user;
        },
    },
};
</script>

<style lang="sass" scoped>
.v-card__title
    word-break: break-word

.row-wrapper
    padding-top: 25px
    padding-bottom: 120px
</style>
