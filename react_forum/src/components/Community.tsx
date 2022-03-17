import { useNavigate, useParams } from 'react-router-dom';
import Feed from './Feed';
import PageWrapper from './PageWrapper';

type Props = {};

function Community({}: Props) {
  const params = useParams();
  const navigate = useNavigate();

  return (
    <PageWrapper type='community' name={params.community}>
      
        <Feed community={params.community} onCommunityPage={true} />
    </PageWrapper>
  );
}

export default Community;
