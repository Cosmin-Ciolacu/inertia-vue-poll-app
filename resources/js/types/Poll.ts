import { PollOption } from "./PollOption";

export type Poll = {
  id: number;
  user_id: number;
  question: string;
  options: PollOption[];
  created_at: string;
  updated_at: string;
  options_sum_votes: number;
};
