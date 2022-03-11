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
export interface singleCommentData {
  isLoaded: boolean;
  comment: IComment;
}
export const defaultPostData: commentData = {
  isLoaded: false,
  comments: [],
};
export const defaultSinglePostData: singleCommentData = {
  isLoaded: false,
  comment: {
    author: '',
    communityName: '',
    content: '',
    createdAt: null,
    thumbsDowns: 0,
    thumbsUps: 0,
    id: '',
    postID: '',
    postTitle: '',
  },
};
