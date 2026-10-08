<template>
  <EventForm :event-id="$route.params.id" :key="$route.params.id" />
</template>

<script>
import EventForm from "./form";
export default {
  components: { EventForm },
};
</script>
