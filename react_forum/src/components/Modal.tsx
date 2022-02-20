import { motion } from 'framer-motion';
import Backdrop from './Backdrop';

type Props = {
  children: JSX.Element;
  handleClose: () => void;
};

const dropIn = {
  hidden: {
    y: '-100vh',
    opacity: 0,
  },
  visible: {
    y: 0,
    opacity: 1,
    transition: {
      duration: 0.5,
      type: 'spring',
      damping: 10,
      stiffness: 100,
    },
  },
  exit: {
    y: '100vh',
    opacity: 0,
  },
};

function Modal({ children, handleClose }: Props) {
  return (
    <Backdrop onClick={handleClose}>
      <motion.section
        onClick={(e) => e.stopPropagation()}
        className="modal"
        variants={dropIn}
        initial="hidden"
        animate="visible"
        exit="exit"
      >
        {children}
      </motion.section>
    </Backdrop>
  );
}

export default Modal;
