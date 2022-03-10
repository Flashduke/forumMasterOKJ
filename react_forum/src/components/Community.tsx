import { useNavigate, useParams } from 'react-router-dom';
import Feed from './Feed';

type Props = {};

function Community({}: Props) {
  const params = useParams();
  const navigate = useNavigate();

  return (
    <>
      <main>
        {params.community} Community
        <Feed community={params.community} onCommunityPage={true} />
      </main>
      <aside></aside>
    </>
  );
}

export default Community;
