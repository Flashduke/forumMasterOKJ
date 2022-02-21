import Login from './Login';
import Signup from './Signup';

type Props = {
  content: string;
  handleClose: () => void;
};

function ModalChildren({ content, handleClose }: Props) {
  if (content === 'Signup') return <Signup></Signup>;
  if (content === 'Login') return <Login handleClose={handleClose}></Login>;
  return <></>;
}
export default ModalChildren;
