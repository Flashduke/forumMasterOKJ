import Login from './Login';
import Signup from './Signup';

type Props = {
  content: string;
};

function ModalChildren({ content }: Props) {
  if (content == 'Signup') return <Signup></Signup>;
  if (content == 'Login') return <Login></Login>;
  return <></>;
}
export default ModalChildren;
