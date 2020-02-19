<template>
  <div>
    <div class="card-body">
      <spinner v-if="$root.loading"></spinner>
      <div v-else-if="questions.length">
        <question-excerpt
          v-for="(question, index) in questions"
          @deleted="remove(index)"
          :question="question"
          :key="question.id"
        ></question-excerpt>
      </div>
      <div v-else class="alert alert-danger">
        <strong>Sorry</strong> There are no questions available.
      </div>
    </div>
    <div class="card-footer">
      <pagination :meta="meta" :links="links"></pagination>
    </div>
  </div>
</template>

<script>
  import QuestionExcerpt from './QuestionExcerpt';
  import Pagination from './Pagination';

  export default {
    components: {
      QuestionExcerpt,
      Pagination,
    },
    data () {
      return {
        questions: [],
        meta: {},
        links: {},
      };
    },
    methods: {
      fetchQuestions () {
        axios.get('/questions', { params: this.$route.query })
          .then(({ data }) => {
            this.questions = data.data;
            this.meta = data.meta;
            this.links = data.links;
          });
      },
      remove (index) {
        this.questions.splice(index, 1);
        this.count--;
      },
    },
    mounted () {
      this.fetchQuestions();
    },
    watch: {
      "$route": 'fetchQuestions',
    },
  };
</script>

<style scoped>

</style>
