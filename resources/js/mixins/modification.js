import Vote from '../components/Vote';
import UserInfo from '../components/UserInfo';
import MEditor from '../components/MEditor';
import highlight from './highlight';
import destroy from './destroy';

export default {
  components: {
    Vote,
    UserInfo,
    MEditor,
  },
  mixins: [highlight, destroy],
  data () {
    return {
      editing: false,
    };
  },
  methods: {
    setEditCache () {},
    restoreFromCache () {},
    delete () {},
    payload () {},
    edit () {
      this.setEditCache();
      this.editing = true;
    },
    cancel () {
      this.restoreFromCache();
      this.editing = false;
    },
    update () {
      axios.put(this.endpoint, this.payload())
        .then(({ data }) => {
          this.bodyHtml = data.body_html;
          this.$toast.success(data.message, "Success", { timeout: 3000 });
          this.editing = false;
        })
        .then(this.highlight)
        .catch(({ response }) => {
          this.$toast.error(response.data.message, "Error", { timeout: 3000 });
        });
    },
  },
};
