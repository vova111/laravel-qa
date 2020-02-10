<template>
  <div class="container">
    <question :question="question"></question>
    <answers :question="question"></answers>
  </div>
</template>

<script>
  import Question from '../Question';
  import Answers from '../Answers';

  export default {
    components: {
      Question,
      Answers,
    },
    props: ['question'],
  }
</script>

<style scoped>

</style>
