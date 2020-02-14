import QuestionsPage from '../components/pages/QuestionsPage';
import QuestionPage from '../components/pages/QuestionPage';
import MyPostsPage from '../components/pages/MyPostsPage';
import NotFoundPage from '../components/pages/NotFoundPage';

const routes = [{
  path: '/',
  component: QuestionsPage,
  name: 'home',
}, {
  path: '/questions',
  component: QuestionsPage,
  name: 'questions',
}, {
  path: '/my-posts',
  component: MyPostsPage,
  name: 'my-posts',
  meta: {
    requiresAuth: true,
  },
}, {
  path: '/questions/:slug',
  component: QuestionPage,
  name: 'questions.show',
}, {
  path: '*',
  component: NotFoundPage,
}];

export default routes;
