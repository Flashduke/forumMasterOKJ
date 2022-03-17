export interface IProfile {
    banner: string;
    createdAt: Date;
    description: string;
    followerCount: number;
    name: string;
    icon: string;
    id: string;
}

export interface profileData {
  isLoaded: boolean;
  data: IProfile;
}

export interface profilesData {
  isLoaded: boolean;
  data: IProfile[];
}

export const defaultProfileData: profileData = {
  isLoaded: false,
  data: null,
};

export const defaultProfilesData: profilesData = {
  isLoaded: false,
  data: [],
};