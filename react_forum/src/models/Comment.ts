export interface IComment {
  author: string;
  communityName: string;
  content: string;
  createdAt: Date;
  thumbsDowns: number;
  thumbsUps: number;
  id: string;
  postID: string;
  postTitle: string;
}

export interface commentData {
  isLoaded: boolean;
  comments: IComment[];
}

export const defaultCommentData: commentData = {
  isLoaded: false,
  comments: [],
};
