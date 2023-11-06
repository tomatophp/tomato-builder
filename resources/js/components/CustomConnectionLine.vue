<script setup>
import {SmoothStepEdge} from "@vue-flow/core";

defineProps({
    sourceX: {
        type: Number,
        required: true,
    },
    sourceY: {
        type: Number,
        required: true,
    },
    targetX: {
        type: Number,
        required: true,
    },
    targetY: {
        type: Number,
        required: true,
    },
    sourcePosition: {
        type: String,
        required: true,
    },
    targetPosition: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <SmoothStepEdge :sourceX="sourceX" :sourceY="sourceY" :targetY="targetY" :targetX="targetX"  :sourcePosition="sourcePosition" :targetPosition="targetPosition" />
</template>
