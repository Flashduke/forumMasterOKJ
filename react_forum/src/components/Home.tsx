import { Link } from 'react-router-dom';
import Feed from './Feed';

export default function Home() {
  return (
    <>
      <main>
        Home
        <br />
        <Link to="/admin">Admin Page</Link>
        <Feed></Feed>
      </main>
      <aside></aside>
    </>
  );
}
