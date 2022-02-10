import {MotionConfig} from "framer-motion";
import Navbar from "./components/Navbar";

function App() {
  return (
    <MotionConfig reducedMotion="user">
      <div className="App dark">
        <Navbar />
        <div className="content"></div>
      </div>
    </MotionConfig>
  );
}

export default App;
