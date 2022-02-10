import {motion} from "framer-motion";
import Backdrop from "./Backdrop";

type Props = {
  children: JSX.Element;
  title?: string;
  handleClose: () => void;
};

const dropIn = {
  hidden: {
    y: "-100vh",
    opacity: 0,
  },
  visible: {
    y: 0,
    opacity: 1,
    transition: {
      duration: 0.5,
      type: "spring",
      damping: 10,
      stiffness: 100,
    },
  },
  exit: {
    y: "100vh",
    opacity: 0,
  },
};

function Modal({children, title, handleClose}: Props) {
  return (
    <Backdrop onClick={handleClose}>
      <motion.div
        onClick={(e) => e.stopPropagation()}
        className="modal"
        variants={dropIn}
        initial="hidden"
        animate="visible"
        exit="exit"
      >
        {title && <h2>{title}</h2>}

        {children}
      </motion.div>
    </Backdrop>
  );
}

export default Modal;