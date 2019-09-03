<template>
  <v-app>
    <nav-bar />

    <v-content>
      <CreateShortlinkForm />
    </v-content>
  </v-app>
</template>

<script>
import NavBar from '@/components/NavBar'
import CreateShortlinkForm from './components/CreateShortlinkForm'

export default {
  name: 'App',
  components: {
    NavBar,
    CreateShortlinkForm
  },
  data: () => ({
    //
  }),
};
</script>
