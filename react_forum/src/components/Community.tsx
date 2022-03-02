import { useNavigate, useParams } from 'react-router-dom';
import Feed from './Feed';

type Props = {};

function Community({}: Props) {
  const params = useParams();
  const navigate = useNavigate();

  return (
    <div className="content">
      {params.community} Community
      <Feed community={params.community} onCommunityPage={true} />
    </div>
  );
}

export default Community;
