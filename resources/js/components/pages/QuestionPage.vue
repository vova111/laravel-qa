<template>
  <div v-if="question.id" class="container">
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
    props: ['slug'],
    data () {
      return {
        question: {},
      };
    },
    mounted () {
      this.fetchQuestion();
    },
    methods: {
      fetchQuestion () {
        axios.get(`/questions/${this.slug}`)
          .then(({ data }) => {
            this.question = data.data;
          })
          .catch(error => console.log(error));
      },
    },
  };
</script>

<style scoped>

</style>
