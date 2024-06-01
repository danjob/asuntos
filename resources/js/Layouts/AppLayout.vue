<template>
    <v-app>
        <v-app-bar color="#36B3F0" app dark absolute>
            <Link class="white--text" href="/">
                <v-toolbar-title>Asuntos</v-toolbar-title>
            </Link>

            <v-spacer></v-spacer>

            <Link as="v-btn" icon x-large :href="route('topics.create')">
                <v-icon>mdi-plus</v-icon>
            </Link>
        </v-app-bar>

        <v-main class="grey lighten-3">
            <v-container>
                <v-row>
                    <v-col cols="12" sm="8" offset-sm="2">
                        <slot />
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
    components: {
        Link,
    },
};
</script>
