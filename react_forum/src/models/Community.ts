export interface ICommunity {
    banner: string;
    createdAt: Date;
    description: string;
    memberCount: number;
    name: string;
    icon: string;
    id: string;
}

export interface communityData {
  isLoaded: boolean;
  data: ICommunity;
}

export interface communitiesData {
  isLoaded: boolean;
  data: ICommunity[];
}

export const defaultCommunityData: communityData = {
  isLoaded: false,
  data: null,
};

export const defaultCommunitiesData: communitiesData = {
  isLoaded: false,
  data: [],
};
