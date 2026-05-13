<script setup lang="ts">
import { computed } from "vue";

type ParsedLabel = {
  before: string;
  text: string;
  after: string;
} | null;

const props = defineProps<{
  label: string;
  for: string;
  link?: string;
}>();

function parseLabel(label: string): ParsedLabel {
  const [before, rest] = label.split("[link]");
  if (!rest) return null;

  const [text, after] = rest.split("[/link]");
  if (text === undefined || after === undefined) return null;

  return { before, text, after };
}

const parsed = computed(() => parseLabel(props.label));
</script>

<template>
  <template v-if="parsed">
    <label :for="props.for">
      {{ parsed.before }}
      <a :href="link" target="_blank" rel="noopener noreferrer">
        {{ parsed.text }}
      </a>
      {{ parsed.after }}
    </label>
  </template>

  <template v-else>
    <label :for="props.for">
      {{ label }}
    </label>
  </template>
</template>
