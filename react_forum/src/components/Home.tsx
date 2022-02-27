import { Link } from 'react-router-dom';
import Feed from './Feed';

export default function Home() {
  

  return (
    <div className="content">
      Home
      <br />
      <Link to="/admin">Admin Page</Link>
      <Feed></Feed>
    </div>
  );
}
